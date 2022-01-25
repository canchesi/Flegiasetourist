# Flegias & Tourist

### Sommario

Si vuole realizzare una base di dati per una azienda di trasporto pubblico marittimo che offre delle soluzioni di viaggio da e verso i porti principali delle isole e del Sud Italia.

La base si interfaccia con i dipendenti dell'azienda e con visitatori tramite l'apposito portale web. Per i visitatori è possibile registrarsi come clienti al fine di poter effettuare la prenotazione di un viaggio.

Ogni utente della piattaforma è identificato dalla propria email di registrazione, e possiede una password codificata in sha256, un nome ed un cognome; inoltre, ad ogni utente è associata una scheda con delle informazioni personali: residenza e domicilio (qualora quest'ultimo non coincida con la prima), composte da una provincia, un comune, un CAP e una via, il CF, un recapito telefonico, la data di nascita e il sesso.

Un dipendente ha inoltre associata una scheda di generalità utili all'azienda, come gruppo sanguigno, colore di capelli e occhi, e altezza.

I dipendenti si suddividono in due categorie: amministratore, il quale è delegato ai lavori d'ufficio e si occupa della gestione completa della piattaforma e degli utenti, e capitano, il quale può guidare o meno una nave per una determinata rotta; è obbligatoria l'assegnazione di un capitano per una rotta.

Le navi possedute dall'azienda sono identificate da un ID numerico e possiedono un nome di battesimo e dei valori massimi di passeggeri e di veicoli trasportabili.

Le rotte sono viaggi identificati dalla nave che partirà per tale tratta in data e orario previsti, e sono composte da varie informazioni: un porto di partenza e uno di arrivo (uno per città), un orario di arrivo previsto, un orario di partenza e uno di arrivo effettivi inseribili dal capitano della nave, due prezzi base per passeggeri maggiorenni e minorenni e, qualora il capitano lo reputasse necessario, una scheda contenente delle note sul viaggio.

Un cliente, una volta registratosi alla piattaforma, può decidere di effettuare una prenotazione di più biglietti che verranno poi pagati prima dell'imbarco; le prenotazioni sono identificate da un codice numerico e in esse sono indicati il numero di passeggeri maggiorenni e minorenni, al fine di un corretto calcolo del prezzo totale e del numero di passeggeri in viaggio su una certa rotta, una data di effettuazione della prenotazione, e la presenza di un veicolo, il quale può essere al più uno per prenotazione; in base alla tipologia del veicolo (autoveicolo, motociclo, camion) vi sono dei sovrapprezzi e un'indicazione sullo spazio occupato, indicato come multipli di una dimensione ideale di un'automobile.

### Operazioni

- #### Capitano

  - **Visualizzazione delle rotte assegnate**: Visualizza a schermo le rotte per lui previste fino a sette giorni successivi e lo storico di tutte le rotte precedenti.

  - **Inserimento partenza e arrivo**: Può inserire la data e l'orario di partenza e arrivo effettivi.

  - **Visualizzazione delle note di viaggio**: Può visualizzare lo storico delle note di viaggio da lui inserite.

  - **Inserimento note di viaggio**: Può inserire delle note sulla rotta effettuata, ma non può modificarle una volta confermate.

- #### Amministratore

  - **Inserimento, rimozione e modifica delle rotte**: Può inserire, rimuovere o modificare una rotta secondo le necessità dell'azienda, cambiando orari e capitano, esclusivamente prima della partenza effettiva.

  - **Inserimento, rimozione e modifica dei dipendenti**: Può inserire o rimuovere un dipendente dalla base di dati, fornendo le credenziali d'accesso all'interessato, o modificare i dati in caso di necessità.

  - **Inserimento e rimozione delle navi**: Può inserire o rimuovere una nave nella base di dati, dipendentemente dagli acquisti o dalle vendite dell'azienda.

  - **Inserimento e rimozione dei porti affiliati**: Può inserire o rimuovere di un porto affiliato nella base di dati, dipendentemente dagli accordi dell'azienda.

- #### Visitatore

  - **Visualizzazione delle rotte**: Può visualizzare le rotte offerte dall'azienda fino a sette giorni successivi.

  - **Registrazione come cliente**: Può effettuare una registrazione come cliente inserendo i dati richiesti al fine di effettuare prenotazioni di biglietti.

- #### Cliente

  - **Prenotazione e annullamento di biglietti**: Può effettuare prenotazioni di biglietti per determinate rotte, indicando i dati richiesti, o effettuare un annullamento entro 24 ore precedenti alla partenza.

  - **Visualizzazione delle prenotazioni**: Può visualizzare lo storico delle prenotazioni effettuate.