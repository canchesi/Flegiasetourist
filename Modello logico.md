# Modello logico

### Ristrutturazione

Le generalizzazioni sono state risolte inserendo un campo "tipo" in Utente che può essere "Amministratore", "Capitano" o "Cliente", rendendo le relazioni delle entità figlie direttamente legate all'entità Utente. Non vi sono relazioni N a N o cicli. 

### Modello relazionale

**Utenti**(<ins>ID</ins>, Email, Password, Nome, Cognome, Tipo, Eliminato)

**Informazioni**(<ins>Utente*</ins>, CF, Telefono, DataNascita, Sesso, ProvinciaR, ComuneR, CAPR, ViaR, ProvinciaD, ComuneD, CAPD, ViaD)

**Colore occhi**(<ins>Valore</ins>)

**Colore capelli**(<ins>Valore</ins>)

**Generalità**(<ins>Utente*</ins>, GruppoSang, ColoreCapelli*, ColoreOcchi*, Altezza)

**Navi**(<ins>IDNave</ins>, Nome, Dismessa)

**Porti**(<ins>Città</ins>)

**Tratte**(<ins>ID</ins>PortoPart*, PortoArr*, PrezzoAd, PrezzoRag, Annullata)

**Rotte**(<ins>ID</ins>, ID nave*, ID tratta*, PartenzaPrev, ArrivoPrev, PartEff, ArrEff, Capitano*, NumPass, Note, Direzione, Annullata)

**Veicoli**(<ins>Tipologia</ins>, Sovrapprezzo)

**Carte di credito**(<ins>Numero</ins>, Intestatario, Data di scadenza, CVV)

**Associazioni utente-carta**(<ins>ID</ins>, ID utente*, Numero carta*, Salvata)

**Prenotazioni**(<ins>Codice</ins>, Rotta*, Pagamento*, DataPren, NumAd, NumRag, Veic*, Totale, Annullato)




