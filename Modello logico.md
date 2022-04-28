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

**Tratte**(<ins>ID</ins>PortoPart*, PortoArr*, PrezzoAd, PrezzoRag, Annullata)

**Rotte**(<ins>ID</ins>, ID nave*, ID tratta*, PartenzaPrev, ArrivoPrev, PartEff, ArrEff, Capitano*, NumPass, Note, Direzione, Annullata)

**Veicoli**(<ins>Tipologia</ins>, Sovrapprezzo)

**Carte di credito**(<ins>Numero</ins>, Intestatario, Data di scadenza, CVV)

**Associazioni utente-carta**(<ins>ID</ins>, ID utente*, Numero carta*, Salvata)

**Prenotazioni**(<ins>Codice</ins>, Rotta*, Pagamento*, DataPren, NumAd, NumRag, Veic*, Totale, Annullato)




