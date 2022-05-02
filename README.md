# Flegias & Tourist

### Sommario

Si vuole realizzare una base di dati per una azienda di trasporto pubblico marittimo che offre delle soluzioni di viaggio da e verso alcuni porti delle isole e del Sud Italia.

La base si interfaccia con i dipendenti dell'azienda e con visitatori tramite l'apposito portale web. Per i visitatori è possibile registrarsi come clienti al fine di poter effettuare la prenotazione di un viaggio.<br>Ogni utente della piattaforma è identificato da un codice identificativo numerico e possiede: una email di registrazione, una password codificata, un nome ed un cognome; inoltre, ad ogni utente è associata una scheda con delle informazioni personali: residenza e domicilio (qualora quest'ultimo non coincida con la prima), composte da una provincia, un comune, un CAP e una via, il CF, un recapito telefonico, la data di nascita e il sesso.<br>Un dipendente ha inoltre associata una scheda di generalità utili all'azienda, come gruppo sanguigno, colore di capelli e occhi, e altezza.<br>Un utente può essere un cliente o un dipendente, e quest’ultimo a sua volta si suddivide in due categorie: amministratore e capitano.

I porti affiliati all'azienda (identificati dalla città di appartenenza) sono raggruppati in coppie per definire le tratte proposte dalla compagnia. Le tratte hanno due prezzi base per passeggeri adulti e minori di 18 anni, e possono essere eliminate dagli amministratori.

Le navi possedute dall'azienda sono identificate da un ID numerico e possiedono un nome di battesimo. Le navi possono anche essere dismesse.

Le rotte sono viaggi identificati da un codice alfanumerico univoco e sono composte da varie informazioni: un orario di partenza previsto, uno di arrivo previsto, un numero di passeggeri prenotati, la tratta percorsa (che sia andata o ritorno), la nave e il capitano assegnati, un orario di partenza e uno di arrivo effettivi e delle note di viaggio compilabili dal capitano. Le rotte possono essere annullate.

Un cliente, una volta registratosi alla piattaforma, può decidere di effettuare una prenotazione di più biglietti relativi ad una specifica rotta che verranno poi pagati o con carta di credito o in contanti al botteghino.<br>Le carte di credito utilizzate possono essere memorizzate a discrezione dell’utente, salvando intestatario, data di scadenza e CVV.<br>Le prenotazioni sono identificate da un codice numerico e in esse sono indicati il numero di passeggeri maggiorenni e minorenni, una data di effettuazione della prenotazione, il totale della spesa, e la presenza di un veicolo; in base alla tipologia del veicolo (autoveicolo, motoveicolo, camion) vi sono dei sovrapprezzi.

### Dizionario

|         **Entità**        |               **Descrizione**               |                                                                            **Attributi**                                                                           | **Identificatore** |
|:-------------------------:|:-------------------------------------------:|:-----------------:|:------------------:|
| Utente                    | Utente della piattaforma                    | ID, nome, cognome, email. password, eliminato                                                                                                                      | ID                 |
| Informazioni              | Informazioni dell’utente                    | Residenza, domicilio, CF, telefono, data di nascita, desso                                                                                                         | Utente             |
| Dipendente                | Dipendente della società                    |                                                                                                                                                                    |                    |
| Cliente                   | Cliente della compagnia                     |                                                                                                                                                                    |                    |
| Amministratore            | Amministratore della società                |                                                                                                                                                                    |                    |
| Capitano                  | Comandante delle navi                       |                                                                                                                                                                    |                    |
| Generalità                | Informazioni aggiuntive dei dipendenti      | Colore capelli, colore occhi, gruppo sanguigno, altezza                                                                                                            | Dipendente         |
| Colore occhi              | Look-up table con colori degli occhi        | Valore                                                                                                                                                             | Valore             |
| Colore capelli            | Look-up table con colori degli capelli      | Valore                                                                                                                                                             | Valore             |
| Navi                      | Navi della società                          | ID, nome, dismessa                                                                                                                                                 | ID                 |
| Porti                     | Porti affiliati alla società                | Città                                                                                                                                                              | Città              |
| Veicoli                   | Veicoli trasportabili                       | Tipologia, sovrapprezzo                                                                                                                                            | Tipologia          |
| Tratte                    | Percorsi possibili per le rotte             | ID, prezzo adulti, prezzo ragazzi, annullata                                                                                                                       | ID                 |
| Rotte                     | Specifici viaggi proposti dalla compagnia   | ID, orario part. previsto, orario part. effettivo, orario arr. previsto, orario arr. effettivo, numero pass. prenotati, note di viaggio, andata/ritorno, annullata | ID                 |
| Carte di credito          | Carte di credito usate/salvate dagli utenti | Numero, intestatario, data di scadenza, CVV                                                                                                                        | Numero             |
| Associazioni utente-carta | Associazioni utente-carta utilizzata        | ID, salvata                                                                                                                                                        | ID                 |
| Prenotazioni              | Prenotazioni effettuate dai clienti         | ID, numero minorenni, numero adulti, subtotale, data prenotazione, annullata                                                                                       | ID                 |

|        **Relazione**        |                 **Descrizione**                 |                                **Componenti**                                |
|:---------------------------:|:-----------------------------------------------:|:----------------------------------------------------------------------------:|
| Appartenenza (informazioni) | Appartenenza delle informazioni ad un utente    | Informazioni, Utenti                                                         |
| Appartenenza (generalità)   | Appartenenza delle generalità ad un dipendente  | Generalità, Dipendenti                                                       |
| Guida                       | Comando di una rotta da un capitano             | Rotte, Capitani                                                              |
| Aggiunta                    | Aggiunta di un veicolo ad una prenotazione      | Veicoli, Prenotazioni                                                        |
| Effettuazione               | Effettuazione di un pagamento                   | Clienti, Associazioni utente-carta                                           |
| Salvataggio                 | Salvataggio delle informazioni carta di credito | Carte di credito, Associazioni utente-carta                                  |
| Pagamento                   | Associazione pagamento a prenotazione           | Prenotazioni, Associazioni utente-carta                                      |
| Riferimento                 | Riferimento di una prenotazione ad una rotta    | Prenotazioni, Rotte                                                          |
| Percorrenza                 | Collegamento tratta percorsa e relativa rotta   | Tratte, Rotte                                                                |
| Assegnazione                | Assegnazione nave ad una rotta                  | Navi, Rotte                                                                  |
| Possiede (Colore occhi)     | Collegamento colore occhi e dipendente          | Colore occhi, Generalità                                                     |
| Possiede (Colore capelli)   | Collegamento colore capelli e dipendente        | Colore capelli, Generalità                                                   |
| Partenza                    | Assegnazione partenza ad un porto (andata)      | Porti, Tratte                                                                |
| Arrivo                      | Assegnazione arrivo ad un porto (andata)        | Porti, Tratte                                                                |


### Vincoli

- Gli orari di partenza e arrivo effettivi sono inseriti dal capitano al momento della partenza e dell'arrivo reali.
- Le note di viaggio sono inserite dal capitano alla conclusione della rotta.
- Gli amministratori sono gli unici che possono gestire completamente la piattaforma.
- Le rotte relative alla stessa tratta possono essere percorse in un verso o nell'altro.
- Può essere selezionato al più un veicolo per prenotazione.
- Intestatario, Data di scadenza e CVV di una carta di credito sono salvati solo se l’utente lo specifica.

### Operazioni

- #### Capitano
  - *Visualizzazione delle rotte assegnate*: Visualizza a schermo le rotte per lui previste e lo storico di tutte le rotte precedenti.
  - *Inserimento partenza e arrivo*: Può inserire la data e l'orario di partenza e arrivo effettivi.
  - *Visualizzazione delle note di viaggio*: Può visualizzare lo storico delle note di viaggio da lui inserite.
  - *Inserimento note di viaggio*: Può inserire delle note sulla rotta effettuata, ma non può modificarle una volta confermate.
  - *Modifica informazioni personali*: Può modificare alcune proprie informazioni.
- #### Amministratore
  - *Inserimento, rimozione e modifica delle rotte*: Può inserire, rimuovere o modificare una rotta secondo le necessità dell'azienda, cambiando orari e capitano, esclusivamente prima della partenza effettiva.
  - *Inserimento, rimozione e modifica dei dipendenti*: Può inserire o rimuovere un dipendente dalla base di dati, fornendo le credenziali d'accesso all'interessato, o modificare i dati in caso di necessità.
  - *Inserimento e rimozione delle navi*: Può inserire o rimuovere una nave nella base di dati, dipendentemente dagli acquisti o dalle vendite dell'azienda.
  - *Inserimento, rimozione e modifica delle tratte*: Può inserire, rimuovere o modificare una tratta a seconda delle necessità dell’azienda.
- #### Visitatore
  - *Visualizzazione delle rotte*: Può visualizzare le rotte offerte dall'azienda in base ad una ricerca.
  - *Registrazione come cliente*: Può effettuare una registrazione come cliente inserendo i dati richiesti al fine di effettuare prenotazioni di biglietti.
- #### Cliente
  - *Prenotazione e annullamento di biglietti*: Può effettuare prenotazioni di biglietti per determinate rotte, indicando i dati richiesti, o effettuare un annullamento entro 24 ore precedenti alla partenza.
  - *Inserimento carte di credito*: Può salvare una carta di credito durante una prenotazione.
  - *Rimozione carte di credito*: Può rimuovere una carta di credito da quelle memorizzate.
  - *Visualizzazione delle prenotazioni*: Può visualizzare lo storico delle prenotazioni effettuate.
  - *Modifica informazioni personali*: Può modificare tutte le proprie informazioni.

# Modello logico

### Ristrutturazione

Le generalizzazioni sono state risolte inserendo un campo "tipo" in Utente che può essere "Amministratore", "Capitano" o "Cliente", rendendo le relazioni delle entità figlie direttamente legate all'entità Utente. La relazione ternaria tra Carte di credito, Clienti (Utenti una volta ristrutturato) e Prenotazioni è gestita tramite un’entità Associazioni utente-carta, tale da gestire la relazione N a N tra le prime due entità sopracitate e permettendo che la stessa sia una chiave esterna in Prenotazioni, tramite una relazione con cardinalità massima (1,N) nel verso Prenotazioni-Associazioni utente-carta.

### Modello relazionale

**Utenti**(<ins>ID</ins>, Email, Password, Nome, Cognome, Tipo, Eliminato)

**Informazioni**(<ins>Utente*</ins>, CF, Telefono, DataNascita, Sesso, ProvinciaR, ComuneR, CAPR, ViaR, ProvinciaD, ComuneD, CAPD, ViaD)

**Colore occhi**(<ins>Valore</ins>)

**Colore capelli**(<ins>Valore</ins>)

**Generalità**(<ins>Utente*</ins>, GruppoSang, ColoreCapelli*, ColoreOcchi*, Altezza)

**Navi**(<ins>IDNave</ins>, Nome, Dismessa)

**Porti**(<ins>Città</ins>)

**Tratte**(<ins>ID</ins>, PortoPart*, PortoArr*, PrezzoAd, PrezzoRag, Annullata)

**Rotte**(<ins>ID</ins>, ID nave*, ID tratta*, PartenzaPrev, ArrivoPrev, PartEff, ArrEff, Capitano*, NumPass, Note, Direzione, Annullata)

**Veicoli**(<ins>Tipologia</ins>, Sovrapprezzo)

**Carte di credito**(<ins>Numero</ins>, Intestatario, Data di scadenza, CVV)

**Associazioni utente-carta**(<ins>ID</ins>, ID utente*, Numero carta*, Salvata)

**Prenotazioni**(<ins>Codice</ins>, Rotta*, Pagamento*, DataPren, NumAd, NumRag, Veic*, Totale, Annullato)
