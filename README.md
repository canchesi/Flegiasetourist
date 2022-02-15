# Flegias & Tourist

### Sommario

Si vuole realizzare una base di dati per una azienda di trasporto pubblico marittimo che offre delle soluzioni di viaggio da e verso alcuni porti delle isole e del Sud Italia.

La base si interfaccia con i dipendenti dell'azienda e con visitatori tramite l'apposito portale web. Per i visitatori è possibile registrarsi come clienti al fine di poter effettuare la prenotazione di un viaggio.

Ogni utente della piattaforma è identificato da un codice idcentificativo numerico e possiede: una email di registrazione, una password codificata, un nome ed un cognome; inoltre, ad ogni utente è associata una scheda con delle informazioni personali: residenza e domicilio (qualora quest'ultimo non coincida con la prima), composte da una provincia, un comune, un CAP e una via, il CF, un recapito telefonico, la data di nascita e il sesso.

Un dipendente ha inoltre associata una scheda di generalità utili all'azienda, come gruppo sanguigno, colore di capelli e occhi, e altezza.

Un utente può essere un cliente o un dipendente, il quale a sua volta si suddivide in due categorie: amministratore e capitano.

I porti affiliati all'azienda (identificati dalla città di appartenenza) sono raggruppati in coppie per definire le tratte proposte dalla compagnia. Le tratte hanno due prezzi base per passeggeri adulti e minori di 18 anni.

Le navi possedute dall'azienda sono identificate da un ID numerico e possiedono un nome di battesimo. Ogni nave è o assegnata ad una tratta specifica o posta come riserva.

Le rotte sono viaggi identificati dalla nave che partirà per la tratta assegnatale e la data e l'orario previsti, e sono composte da varie informazioni: un porto di partenza e uno di arrivo, un orario di arrivo previsto, un orario di partenza e uno di arrivo effettivi della nave e una scheda contenente delle note sul viaggio.

Un cliente, una volta registratosi alla piattaforma, può decidere di effettuare una prenotazione di più biglietti relativi ad una specifica rotta che verranno poi pagati prima dell'imbarco; le prenotazioni sono identificate da un codice numerico e in esse sono indicati il numero di passeggeri maggiorenni e minorenni e una data di effettuazione della prenotazione, e la presenza di un veicolo; in base alla tipologia del veicolo (autoveicolo, motoveicolo, camion) vi sono dei sovrapprezzi.

### Dizionario

| Entità         | Descrizione                               | Attributi                                                                                                                                             | Identificatore               |
|----------------|-------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------|
| Utente         | Utente della piattaforma                  | ID, Email, Nome, Cognome, Password, Eliminato                                                                                                         | ID                           |
| Informazioni   | Informazioni dell'utente                  | Residenza, Domicilio, CF, Telefono, Data di nascita, Sesso                                                                                            | Utente                       |
| Dipendente     | Dipendente della società                  |                                                                                                                                                       |                              |
| Cliente        | Cliente della compagnia                   |                                                                                                                                                       |                              |
| Amministratore | Amministratore della società              |                                                                                                                                                       |                              |
| Capitano       | Comandante delle navi                     |                                                                                                                                                       |                              |
| Generalità     | Informazioni aggiuntive dei dipendenti    | Colore capelli, Colore occhi, Gruppo sanguigno, Altezza                                                                                               | Dipendente                   |
| Rotta          | Specifici viaggi proposti dalla compagnia | Data partenza prevista, Data arrivo prevista, Data partenza effettiva, Data arrivo affettiva, Numero passeggeri prenotati, Note di viaggio, Annullata | Data partenza prevista, Nave |
| Navi           | Navi della società                        | ID, Nome, Dismessa                                                                                                                                    | ID                           |
| Tratte         | Percorsi possibili per le rotte           | Prezzo adulto, Prezzo ragazzo                                                                                                                         | Porto                        |
| Porti          | Porti affiliati alla società              | Città                                                                                                                                                 | Città                        |
| Veicoli        | Veicoli trasportabili                     | Tipologia, Sovrapprezzo                                                                                                                               | Tipologia                    |
| Prenotazioni   | Prenotazioni effettuabili da un cliente   | Codice, Numero passeggeri adulti, Numero passeggeri ragazzi, Data prenotazione                                                                        | Codice                       |

| Relazione                   | Descrizione                                       |
|-----------------------------|---------------------------------------------------|
| Appartenenza (informazioni) | Appartenenza delle informazioni ad un  utente     |
| Appartenenza (generalità)   | Appartenenza delle generalità ad un dipendente    |
| Guida                       | Comando di una rotta da un capitano               |
| Operazione                  | Effettuazione di una prenotazione da un cliente   |
| Aggiunta                    | Aggiunta di un veicolo ad una prenotazione        |
| Riferimento                 | Riferimento di una prenotazione ad una rotta      |
| Percorrenza                 | Percorrenza di una nave in relazione ad una rotta |
| Assegnata                   | Assegnazione di una tratta ad una nave            |
| Percorso                    | Scelta tratta per una rotta                       |
| Partenza/Arrivo             | Ruolo dei porti in una tratta (andata)            |


### Vincoli

- Una rotta deve essere comandata da uno e un solo capitano, ma non tutti i capitani devono comandare una rotta.
- Gli orari di partenza e arrivo effettivi sono inseriti dal capitano al momento della partenza e dell'arrivo reali.
- Gli amministratori sono gli unici che possono gestire completamente la piattaforma.
- Le rotte relative alla stessa tratta possono essere percorse in un verso o nell'altro.
- Può essere selezionato al più un veicolo per prenotazione.
- Solo i clienti possono effettuare una prenotazione.

### Operazioni

- #### Capitano

  - **Visualizzazione delle rotte assegnate**: Visualizza a schermo le rotte per lui previste e lo storico di tutte le rotte precedenti.

  - **Inserimento partenza e arrivo**: Può inserire la data e l'orario di partenza e arrivo effettivi.

  - **Visualizzazione delle note di viaggio**: Può visualizzare lo storico delle note di viaggio da lui inserite.

  - **Inserimento note di viaggio**: Può inserire delle note sulla rotta effettuata, ma non può modificarle una volta confermate.

  - **Modifica informazioni personali**: Può modificare alcune proprie informazioni.

- #### Amministratore

  - **Inserimento, rimozione e modifica delle rotte**: Può inserire, rimuovere o modificare una rotta secondo le necessità dell'azienda, cambiando orari e capitano, esclusivamente prima della partenza effettiva.

  - **Inserimento, rimozione e modifica dei dipendenti**: Può inserire o rimuovere un dipendente dalla base di dati, fornendo le credenziali d'accesso all'interessato, o modificare i dati in caso di necessità.

  - **Inserimento e rimozione delle navi**: Può inserire o rimuovere una nave nella base di dati, dipendentemente dagli acquisti o dalle vendite dell'azienda.

- #### Visitatore

  - **Visualizzazione delle rotte**: Può visualizzare le rotte offerte dall'azienda in base ad una ricerca.

  - **Registrazione come cliente**: Può effettuare una registrazione come cliente inserendo i dati richiesti al fine di effettuare prenotazioni di biglietti.

- #### Cliente

  - **Prenotazione e annullamento di biglietti**: Può effettuare prenotazioni di biglietti per determinate rotte, indicando i dati richiesti, o effettuare un annullamento entro 24 ore precedenti alla partenza.

  - **Visualizzazione delle prenotazioni**: Può visualizzare lo storico delle prenotazioni effettuate.

  - **Modifica informazioni personali**: Può modificare tutte le proprie informazioni.