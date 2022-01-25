# Modello logico

### Ristrutturazione

Lo schema concettuale non prevede ridondanze o cicli. Le generalizzazioni sono state risolte inserendo un capo "tipo" in Utente che può essere "Amministratore", "Capitano" o "Cliente", rendendo le relazioni delle entità figlie direttamente legate all'entità Utente. 

**Utenti**(<u>ID</u>, Email, Password, Nome, Cognome, Tipo, Eliminato)

**Informazioni**(<u>Utente*</u>, CF, Telefono, DataNascita, Sesso, ProvinciaR, ComuneR, CAPR, ViaR, ProvinciaD, ComuneD, CAPD, ViaD)

**Generalità**(<u>Utente*</u>, GruppoSang, ColoreCapelli, ColoreOcchi, Altezza)

**Navi**(<u>IDNave</u>, Nome, NumMaxPass, NumMaxVeic)

**Porti**(<u>Città</u>)

**Tratte**(<u>PortoPart*</u>, <u>PortoArr*</u>, PrezzoMagg, PrezzoMin)

**NoteViaggio**(<u>Nave*</u>, <u>PartenzaPrev*</u>, Contenuto)

**Rotte**(<u>Nave*</u>, <u>PartenzaPrev</u>, ArrivoPrev, PartEff, ArrEff, Tratta*)

**Veicoli**(<u>Tipologia</u>, Sovrapprezzo, SpazioOcc)

**Biglietti**(<u>Codice</u>, Utente*, DataPren, PersMagg, PersMin, Veic*)




