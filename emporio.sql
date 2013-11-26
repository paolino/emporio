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
CREATE TABLE pin ( 

    utente   INTEGER NOT NULL references utenti ON DELETE CASCADE,
    pin  INTEGER NOT NULL,
    rilascio TEXT    NOT NULL
                     DEFAULT (date('now','localtime'))
    );
CREATE TRIGGER pin after insert on pin begin
    update utenti set pin = new.pin where utente=new.utente;
    end;
CREATE TABLE valutazioni ( 
    utente INTEGER NOT NULL REFERENCES utenti
                    ON DELETE CASCADE,
    punti  REAL    CHECK ( punti >= 0 ),
    data   DATE    NOT NULL
                   DEFAULT (date('now','localtime')),
    note   TEXT  not null
    );
CREATE TRIGGER valutazioni after insert on valutazioni begin
    update utenti set punti = round(new.punti,2), valutazione = new.data where utente=new.utente; 
    end;
CREATE VIEW nuovoutente as select utente,colloquio,nominativo,pin,punti,valutazione,residuo from utenti;
CREATE TRIGGER nuovoutente instead of insert on nuovoutente begin
    insert into utenti (utente,colloquio,nominativo,residuo) values (new.utente,new.colloquio,new.nominativo,new.residuo);
    insert into pin (utente,pin) values (new.utente,new.pin);
    insert into valutazioni (utente,punti,data,note) values (new.utente,round(new.punti,2),new.valutazione,'ingresso');
    end;
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
CREATE TABLE prezzi ( 
    prezzo   DOUBLE  NOT NULL primary key
    );
CREATE TABLE acquisti ( 
    acquisto INTEGER PRIMARY KEY,
    utente  INTEGER NOT NULL
                     REFERENCES utenti ON DELETE CASCADE,
    apertura TEXT    NOT NULL
                     DEFAULT CURRENT_TIMESTAMP
    );
CREATE VIEW nuovoacquisto as select colloquio,utente from utenti;
CREATE TABLE chiusure (
	acquisto integer not null unique references acquisti  ON DELETE CASCADE,
	chiusura NOT NULL
                     DEFAULT CURRENT_TIMESTAMP
	);
CREATE VIEW acquisti_aperti as select acquisto,utente from acquisti where acquisto not in (select acquisto from chiusure);
CREATE TRIGGER doppio_acquisto before insert on acquisti when (new.utente in (select utente from acquisti_aperti)) begin
	select raise(abort,"due acquisti contemporanei per utente");
	end;
CREATE VIEW chiusura as select acquisto,pin from acquisti_aperti join utenti using(utente);
CREATE TRIGGER chiusura_errata instead of insert on chiusura when (new.pin != (select pin from chiusura where acquisto = new.acquisto)) begin
	select raise (abort,"PIN sbagliato");
	end;
CREATE TRIGGER chiusura instead of insert on chiusura when (new.pin == (select pin from chiusura where acquisto = new.acquisto)) begin
	insert into chiusure (acquisto) values (new.acquisto);
	end;
CREATE TABLE amministrazione (login text not null primary key);
CREATE VIEW fallimento as select acquisto from acquisti_aperti;
CREATE TRIGGER recupero_spesa_per_fallimento instead of insert on fallimento begin	
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
CREATE TRIGGER ricaricadoppia before INSERT ON ricariche 
when ((select data from ricariche where date(data,'start of month') = date('now','start of month')) notnull)
        BEGIN select raise(abort,"questo mese la ricarica è già avvenuta"); end;
CREATE TABLE spese ( 
    spesa integer primary key,
    acquisto INTEGER NOT NULL
                     REFERENCES acquisti ON DELETE CASCADE,
    prezzo double NOT NULL,
    prodotto text
);
CREATE VIEW cancella as select acquisto,prezzo,prodotto from spese;
CREATE TRIGGER cancella instead of insert on cancella when ((select spesa from spese where prezzo = new.prezzo and acquisto = new.acquisto and ((prodotto isnull and new.prodotto isnull) or new.prodotto = prodotto)) notnull) begin
delete from spese where  spesa = (select spesa from spese where prezzo = new.prezzo and acquisto = new.acquisto and  ((prodotto isnull and new.prodotto isnull) or new.prodotto = prodotto) limit 1);
 update utenti set residuo = round(residuo + new.prezzo,2) where utente = (select utente from acquisti_aperti where acquisto = new.acquisto);
end;
CREATE TRIGGER acquisto_valido after insert on spese when ((select acquisto from chiusure where acquisto = new.acquisto) notnull) begin
        select raise(abort,"acquisto già chiuso");
        end;
CREATE TRIGGER riduzione_residuo after insert on spese begin
        update utenti set 
                residuo = round(residuo - new.prezzo,2) where utente = (select utente from  acquisti where acquisto = new.acquisto);
end;
CREATE INDEX aquisto_of_spese on spese (acquisto);
CREATE TABLE prodotti (nome text primary key not null, prezzo double not null check (prezzo > 0));
CREATE VIEW scontrino as select acquisti.acquisto ,spese.prezzo,prodotto,count(*) as numero,count(*) * prezzo as valore from acquisti join spese on
(acquisti.acquisto = spese.acquisto) group by spese.prezzo,spese.acquisto,spese.prodotto;
CREATE VIEW totali as SELECT acquisto,utente,sum(valore) as valore,sum (numero) as numero , apertura FROM scontrino join acquisti  using (acquisto) group by acquisto;
CREATE VIEW r as select acquisti.acquisto ,spese.prezzo,prodotto,count(*) as numero,count(*) * prezzo as valore from
   acquisti join spese on
     (acquisti.acquisto = spese.acquisto) group by spese.prezzo,spese.acquisto,spese.prodotto;
CREATE TRIGGER nuovoacquisto instead of insert on nuovoacquisto begin
        select case when ((select utente from utenti where utente = new.utente and colloquio = new.colloquio) isnull) then raise (abort,"utente sconosciuto") end;
        insert into acquisti (utente) values (new.utente);
        end;
