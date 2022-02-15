# Modello logico

### Ristrutturazione

Lo schema concettuale prevede un ciclo tra le entità "Navi", "Tratte" e "Rotte", ma è stato lasciato tale in quanto una nave assegnata ad una rotta non è necessariamente legata alla tratta percorsa (nave di riserva). Le generalizzazioni sono state risolte inserendo un campo "tipo" in Utente che può essere "Amministratore", "Capitano" o "Cliente", rendendo le relazioni delle entità figlie direttamente legate all'entità Utente. 

### Modello relazionale

**Utenti**(<u>ID</u>, Email, Password, Nome, Cognome, Tipo, Eliminato)

**Informazioni**(<u>Utente*</u>, CF, Telefono, DataNascita, Sesso, ProvinciaR, ComuneR, CAPR, ViaR, ProvinciaD, ComuneD, CAPD, ViaD)

**Generalità**(<u>Utente*</u>, GruppoSang, ColoreCapelli, ColoreOcchi, Altezza)

**Navi**(<u>IDNave</u>, Nome, Tratta*, Dismessa)

**Porti**(<u>Città</u>)

**Tratte**(<u>PortoPart*</u>, <u>PortoArr*</u>, PrezzoAd, PrezzoRag)

**Rotte**(<u>Nave*</u>, <u>PartenzaPrev</u>, ArrivoPrev, PartEff, ArrEff, Tratta*, NumPass, Note, Direzione, Annullata)

**Veicoli**(<u>Tipologia</u>, Sovrapprezzo)

**Biglietti**(<u>Codice</u>, Rotta*, Utente*, DataPren, NumAd, NumRag, Veic*, Annullato)




