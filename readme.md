# Progetto SQL Injection

## Descrizione

Questo progetto dimostra un attacco di SQL Injection di tipo inband su un'applicazione web vulnerabile, utilizzando Docker per configurare l'ambiente.

## Struttura del Progetto
```bash
/homework-sqli
├── docker-compose.yml
├── Dockerfile
├── init.sql
├── logout.php
├── login.php
└── welcome.php
```
## Requisiti

- **Docker** e **Docker Compose** installati
- Un terminale per eseguire i comandi

## Installazione

1. **Clona il repository** o crea la struttura delle cartelle come mostrato sopra.

2. **Modifica i file** se necessario (ad esempio, per adattare le credenziali o le configurazioni).

3. **Esegui i seguenti comandi per avviare i contenitori:**

 ```bash
docker-compose up --build
```

4. **Accedi all'applicazione web aprendo il browser e navigando su http://localhost:8080/login.php.**
5. **Accedi all'applicazione phpmyadmin aprendo il browser e navigando su http://localhost:8888/.**

## Tipi di Attacco
**Tautologia:**
Esempio di input: 
```bash 
admin' OR '1'='1
```

**Commento di Fine Riga:**
Esempio di input: 
```bash 
admin'; -- 
```

**Query Piggybacked:**
Esempio di input: 
```bash 
admin'; DROP TABLE users; --
```
## Compromissione delle Proprietà CIA
Utilizzando questi attacchi, è possibile compromettere:

**Confidenzialità:** Accesso non autorizzato ai dati.

**Integrità:** Modifica o eliminazione di dati nel database.

## Avvio e Arresto del Progetto
Per avviare il progetto:
```bash
docker-compose up --build
```
Per fermare il progetto:

```bash
docker-compose down
```
