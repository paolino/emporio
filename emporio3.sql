pragma foreign_key=on;
/*********************/
/* anagrafe minimale */
/*********************/

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

/********************/
/* rinnovo pin */
/********************/
CREATE TABLE pin ( 

    utente   INTEGER NOT NULL references utenti,
    pin  INTEGER NOT NULL,
    rilascio TEXT    NOT NULL
                     DEFAULT (date('now','localtime'))
    );

create trigger pin after insert on pin begin
    update utenti set pin = new.pin where utente=new.utente;
    end;

/******************************
** valutazioni utenti *
******************************/

CREATE TABLE valutazioni ( 
    utente INTEGER REFERENCES utenti
                   NOT NULL,
    punti  REAL    CHECK ( punti >= 0 ),
    data   DATE    NOT NULL
                   DEFAULT (date('now','localtime')),
    note   TEXT  not null
    );

create trigger valutazioni after insert on valutazioni begin
    update utenti set punti = new.punti, valutazione = new.data where utente=new.utente; 
    end;

create view nuovoutente as select utente,colloquio,nominativo,pin,punti,valutazione,residuo from utenti;

create trigger nuovoutente instead of insert on nuovoutente begin
    insert into utenti (utente,colloquio,nominativo,residuo) values (new.utente,new.colloquio,new.nominativo,new.residuo);
    insert into pin (utente,pin) values (new.utente,new.pin);
    insert into valutazioni (utente,punti,data,note) values (new.utente,new.punti,new.valutazione,'ingresso');
    end;

/*******************************/
/* eventi di ricarica */
/*******************************/


CREATE TABLE ricariche ( 
    data TEXT NOT NULL
              UNIQUE
              DEFAULT (date('now','localtime'))
    );


CREATE TRIGGER ricarica AFTER INSERT ON ricariche
        BEGIN
            UPDATE utenti
               SET residuo = punti
               where julianday() < julianday (valutazione,'+6 months');
        end;
CREATE TRIGGER ricaricadoppia AFTER INSERT ON ricariche 
		when ((select data from ricariche where (date(data,'start of month') = date('now','start of month'))) notnull)
        BEGIN select raise(abort,"questo mese la ricarica è già avvenuta"); end;
             


/***********************************************/
/*********************************/
/* gestione magazzino e acquisti */
/*********************************/
/***********************************************/


/*********************************/
/* archivio articoli *************/
/*********************************/

CREATE TABLE articoli ( 
    articolo    INTEGER PRIMARY KEY
                        NOT NULL,
    descrizione TEXT    NOT NULL,
    magazzino integer not null default 0 check (magazzino >= 0),
    data        DATE    NOT NULL
                        DEFAULT CURRENT_TIMESTAMP 
    );

/****************************/
/* storico modifiche prezzi */
/****************************/

CREATE TABLE prezzi ( 
    articolo INTEGER REFERENCES articoli,
    prezzo   DOUBLE  NOT NULL,
    data     TEXT    NOT NULL
                     DEFAULT CURRENT_TIMESTAMP 
    );

/************************/
/* vista prezzi attuali */
/************************/
create view quadro_articoli as 
	select articolo,descrizione,magazzino,prezzo from (select articolo,descrizione,magazzino,prezzo,max(prezzi.data) from articoli left outer join prezzi using (articolo) group by articolo);

/******************************/
/* storico carichi magazzino **/
/******************************/
create table carico (
    articolo INTEGER REFERENCES articoli,
    carico not null default 0 check (carico >= 0),
    data        DATE    NOT NULL
                        DEFAULT CURRENT_TIMESTAMP 
    );

/***************************/
/* aggiornamento magazzino */
/***************************/

create trigger carico after insert on carico begin
	update articoli set magazzino = magazzino + new . carico where articolo=new.articolo;
	end;
	
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

create view acquisti_aperti as select acquisto,utente from acquisti where acquisto not in (select acquisto from chiusure);

create trigger doppio_acquisto before insert on acquisti when (new.utente in (select utente from acquisti_aperti)) begin
	select raise(abort,"due acquisti contemporanei per utente");
	end;

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
    articolo INTEGER NOT NULL
                     REFERENCES articoli
    );



/**********************************************/
/* controllo per spesa di acquisto non chiuso */
/**********************************************/

create trigger acquisto_valido after insert on spese when ((select acquisto from chiusure where acquisto = new.acquisto) notnull) begin
	select raise(abort,"acquisto già chiuso");
	end; 

/**********************************************/
/* controllo per spesa di articolo con prezzo */
/**********************************************/

create trigger articolo_prezzato after insert on spese when ((select prezzo from quadro_articoli where articolo = new.articolo) isnull) begin
	select raise(abort,"articolo senza prezzo");
	end; 


/******************************************************************/
/* effetto di spesa di riduzione residuo per la pin coinvolta */
/******************************************************************/

create trigger riduzione_residuo after insert on spese begin
	update utenti set 
		residuo = residuo - (select prezzo from quadro_articoli where articolo = new.articolo) 
			where utente = (select utente from  acquisti where acquisto = new.acquisto);
	end;


	
/* cancellazione spesa */
create view cancella as select acquisto,articolo from acquisti_aperti join spese using (acquisto);

create trigger cancella instead of insert on cancella when 
	((select spesa from spese where articolo = new.articolo and acquisto = new.acquisto) notnull) begin
	delete from spese where  spesa = (select spesa from spese where articolo = new.articolo and acquisto = new.acquisto limit 1);
	update utenti set residuo = residuo + (select prezzo from quadro_articoli where articolo = new.articolo) where
		utente = (select utente from acquisti_aperti where acquisto = new.acquisto);
	
	end;
		


create view scontrino as select acquisti.acquisto ,spese.articolo,descrizione,count(*) as numero,count(*) * prezzo as valore from 
   acquisti join quadro_articoli join spese on 
     (acquisti.acquisto = spese.acquisto and quadro_articoli.articolo = spese.articolo) group by spese.articolo,spese.acquisto;

 
create table amministrazione (login text not null);
create table spese_semplici (
	acquisto integer not null references acquisti,
	spesa double not null,
        data        DATE    NOT NULL
                        DEFAULT CURRENT_TIMESTAMP 
	);

create trigger spesa_semplice_aperta before insert on spese_semplici when ((select utente from acquisti_aperti where acquisto = new.acquisto) isnull) begin
	select raise (abort,"acquisto non aperto");
	end;
create trigger spese_semplici after insert on spese_semplici begin
	update utenti set residuo = residuo - new.spesa where utente =  (select utente from acquisti_aperti where acquisto = new.acquisto);
	end;
create trigger recupero_spesa before insert on spese_semplici 
	when ((select spesa from spese_semplici join acquisti_aperti using (acquisto) where acquisti_aperti.acquisto = new.acquisto) notnull) begin
	update utenti set residuo 
		= residuo + (select spesa from spese_semplici join acquisti_aperti using (acquisto) where acquisti_aperti.acquisto = new.acquisto) 
			where utente =  (select utente from acquisti_aperti where acquisto = new.acquisto); 
	delete from spese_semplici where acquisto = new.acquisto;
	end;
/*
create trigger recupero_spesa_per_fallimento instead of insert on fallimento begin 
	case when ((select spesa from spese_semplici join acquisti_aperti where acquisti_aperti.acquisto = new.acquisto) notnull) 
	 then 	update utenti set residuo = residuo + (select sum(prezzo) from spese join quadro_articoli using(articolo) where acquisto = new.acquisto) where
			utente = (select utente from acquisti_aperti where acquisto = new.acquisto); end;
(select prezzo from spese join quadro_articoli using(articolo) where acquisto = new.acquisto) notnull)

*/
create view fallimento as select acquisto from acquisti_aperti;

create trigger recupero_spesa_per_fallimento instead of insert on fallimento 
	when ((select spesa from spese_semplici join acquisti_aperti where acquisti_aperti.acquisto = new.acquisto) notnull) begin
	update utenti set residuo 
		= residuo + (select spesa from spese_semplici join acquisti_aperti where acquisti_aperti.acquisto = new.acquisto) 
			where utente =  (select utente from acquisti_aperti where acquisto = new.acquisto); 
	delete from spese_semplici where acquisto = new.acquisto;
	delete from acquisti where acquisto = new.acquisto;
	end;

