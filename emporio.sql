pragma foreign_key=on;

/*******************************************************/
/* anagrafe con elementi relativi a  pin e valutazioni */
/*******************************************************/

CREATE TABLE utenti ( 
    utente         INTEGER PRIMARY KEY NOT NULL,
    colloquio      INTEGER NOT NULL,
    pin            integer not null default 0,
    nominativo     TEXT    NOT NULL UNIQUE,
    punti          real check (punti >= 0) ,
    valutazione    TEXT ,
    residuo        REAL CHECK ( residuo >= 0 ),
    inserimento    TEXT   NOT NULL DEFAULT (date('now','localtime'))

    );

/************************/
/* storico rinnovo pin */
/***********************/
CREATE TABLE pin ( 

    utente   INTEGER NOT NULL references utenti,
    pin  INTEGER NOT NULL,
    rilascio TEXT    NOT NULL
                     DEFAULT (date('now','localtime'))
    );

create trigger pin after insert on pin begin
    update utenti set pin = new.pin where utente=new.utente;
    end;

/******************************/
/** valutazioni utenti */
/******************************/

CREATE TABLE valutazioni ( 
    utente INTEGER REFERENCES utenti
                   NOT NULL,
    punti  REAL    CHECK ( punti >= 0 ),
    data   DATE    NOT NULL
                   DEFAULT (date('now','localtime')),
    note   TEXT  not null
    );


create trigger valutazioni after insert on valutazioni begin
    update utenti set punti = round(new.punti,2), valutazione = new.data where utente=new.utente; 
    end;

/****************************************/
/* introduzione semplificata utente */
/* le tabelle pin e valutazione vengono popolate di conseguenza */
/*********************************************/

create view nuovoutente as select utente,colloquio,nominativo,pin,punti,valutazione,residuo from utenti;

create trigger nuovoutente instead of insert on nuovoutente begin
    insert into utenti (utente,colloquio,nominativo,residuo) values (new.utente,new.colloquio,new.nominativo,new.residuo);
    insert into pin (utente,pin) values (new.utente,new.pin);
    insert into valutazioni (utente,punti,data,note) values (new.utente,round(new.punti,2),new.valutazione,'ingresso');
    end;

/************************************/
/* eventi di ricarica valore tessere*/
/************************************/


CREATE TABLE ricariche ( 
    data TEXT NOT NULL
              UNIQUE
              DEFAULT (date('now','localtime'))
    );


/**********************************/
/* validità valutazione ***********/
/**********************************/

CREATE TRIGGER ricarica AFTER INSERT ON ricariche
        BEGIN
            UPDATE utenti
               SET residuo = punti
               where julianday() < julianday (valutazione,'+6 months');
        end;

/*****************************************/
/* controllo di ricarica singola mensile */
/*****************************************/

CREATE TRIGGER ricaricadoppia before INSERT ON ricariche 
		when ((select data from ricariche where date(data,'start of month') = date('now','start of month')) notnull)
        BEGIN select raise(abort,"questo mese la ricarica è già avvenuta"); end;
             


/*********************************/
/* archivio articoli *************/
/*********************************/

CREATE TABLE prezzi ( 
    prezzo   DOUBLE  NOT NULL primary key
    );


/*********************/
/* archivio acquisti */
/*********************/

CREATE TABLE acquisti ( 
    acquisto INTEGER PRIMARY KEY,
    utente  INTEGER NOT NULL
                     REFERENCES utenti,
    apertura TEXT    NOT NULL
                     DEFAULT CURRENT_TIMESTAMP
    );


/*******************************/
/* eventi di chiusura acquisto */
/*******************************/

create table chiusure (
	acquisto integer not null references acquisti unique ,
	chiusura NOT NULL
                     DEFAULT CURRENT_TIMESTAMP
	);

/*************************************/
/* selezione acquisti senza chiusura */
/*************************************/

create view acquisti_aperti as select acquisto,utente from acquisti where acquisto not in (select acquisto from chiusure);

/*************************************/
/* controllo di acquisto aperto singolo per ogni utente */
/**********************************************************/
create trigger doppio_acquisto before insert on acquisti when (new.utente in (select utente from acquisti_aperti)) begin
	select raise(abort,"due acquisti contemporanei per utente");
	end;

/***************************************/
/* chiusura con controllo pin */
/**********************************/

create view chiusura as select acquisto,pin from acquisti_aperti join utenti using(utente);
create trigger chiusura_errata instead of insert on chiusura when (new.pin != (select pin from chiusura where acquisto = new.acquisto)) begin
	select raise (abort,"PIN sbagliato");
	end;
create trigger chiusura instead of insert on chiusura when (new.pin == (select pin from chiusura where acquisto = new.acquisto)) begin
	insert into chiusure (acquisto) values (new.acquisto);
	end;

/********************************************/
/* archivio voci spesa riferite ad acquisti */
/********************************************/

CREATE TABLE spese ( 
    spesa integer primary key,
    acquisto INTEGER NOT NULL
                     REFERENCES acquisti,
    prezzo double NOT NULL
                     REFERENCES prezzi
    );


/**********************************************/
/* controllo per spesa di acquisto non chiuso */
/**********************************************/

create trigger acquisto_valido after insert on spese when ((select acquisto from chiusure where acquisto = new.acquisto) notnull) begin
	select raise(abort,"acquisto già chiuso");
	end; 



/******************************************************************/
/* effetto di spesa di riduzione residuo per l'utente coinvolto */
/******************************************************************/

create trigger riduzione_residuo after insert on spese begin
	update utenti set 
		residuo = round(residuo - new.prezzo,2)	where utente = (select utente from  acquisti where acquisto = new.acquisto);

	end;

/********************************/
/* cancellazione spesa articolo */
/********************************/

create view cancella as select acquisto,prezzo from spese;

create trigger cancella instead of insert on cancella when 
	((select spesa from spese where prezzo = new.prezzo and acquisto = new.acquisto) notnull) begin
	delete from spese where  spesa = (select spesa from spese where prezzo = new.prezzo and acquisto = new.acquisto limit 1);
	update utenti set residuo = round(residuo + new.prezzo,2) where
		utente = (select utente from acquisti_aperti where acquisto = new.acquisto);

	end;
		



/********************************************/
/* passwords di accesso all'amministrazione */
/********************************************/

create table amministrazione (login text not null primary key);


/*********************************************************/
/* gestione fallimento operazione in cassa */
/*********************************************************/

create view fallimento as select acquisto from acquisti_aperti;

create trigger recupero_spesa_per_fallimento instead of insert on fallimento begin	
	update utenti set residuo 
		= round(residuo + (
			select case 
				when ((select prezzo from spese where acquisto = new.acquisto) notnull)
					then (select sum(prezzo) from spese where acquisto = new.acquisto) 
					else 0 
				end
			),2)
			where utente =  (select utente from acquisti_aperti where acquisto = new.acquisto);
	delete from spese where acquisto = new.acquisto;
	delete from acquisti where acquisto = new.acquisto;
	end;

/***********************************/
/* amministrazione *****************/
/***********************************/



create view scontrino as select acquisti.acquisto ,spese.prezzo,count(*) as numero,count(*) * prezzo as valore from
   acquisti join spese on
     (acquisti.acquisto = spese.acquisto) group by spese.prezzo,spese.acquisto;

 

create view totali as SELECT acquisto,utente,sum(valore) as valore,apertura FROM scontrino join acquisti  using (acquisto) group by acquisto;
