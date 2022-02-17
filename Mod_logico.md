# Modello logico

### Ristrutturazione

Lo schema concettuale prevede un ciclo tra le entità "Navi", "Tratte" e "Rotte", ma è stato lasciato tale in quanto una nave assegnata ad una rotta non è necessariamente legata alla tratta percorsa (nave di riserva). Le generalizzazioni sono state risolte inserendo un campo "tipo" in Utente che può essere "Amministratore", "Capitano" o "Cliente", rendendo le relazioni delle entità figlie direttamente legate all'entità Utente. 

### Modello relazionale

**Utenti**(<ins>ID</ins>, Email, Password, Nome, Cognome, Tipo, Eliminato)

**Informazioni**(<ins>Utente*</ins>, CF, Telefono, DataNascita, Sesso, ProvinciaR, ComuneR, CAPR, ViaR, ProvinciaD, ComuneD, CAPD, ViaD)

**Generalità**(<ins>Utente*</ins>, GruppoSang, ColoreCapelli, ColoreOcchi, Altezza)

**Navi**(<ins>IDNave</ins>, Nome, Tratta*, Dismessa)

**Porti**(<ins>Città</ins>)

**Tratte**(<ins>PortoPart*</ins>, <ins>PortoArr*</ins>, PrezzoAd, PrezzoRag)

**Rotte**(<ins>Nave*</ins>, <ins>PartenzaPrev</ins>, ArrivoPrev, PartEff, ArrEff, Tratta*, NumPass, Note, Direzione, Annullata)

**Veicoli**(<ins>Tipologia</ins>, Sovrapprezzo)

**Biglietti**(<ins>Codice</ins>, Rotta*, Utente*, DataPren, NumAd, NumRag, Veic*, Annullato)




