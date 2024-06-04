 #!/usr/bin/python3
print ("Content-Type: text/html\n\n")

import cgi, cgitb, os, sys, sqlite3, time
cgitb.enable()

# Existenz feststellen
if os.path.exists("cwcsqlite.db"):
    print("Datei bereits vorhanden")
    sys.exit(0)

# Verbindung zur Datenbank erzeugen
connection = sqlite3.connect("cwcsqlite.db")

# Datensatzcursor erzeugen
cursor = connection.cursor()

# Tabelle erzeugen
sql = "CREATE TABLE cwcsqlite(" \
      "id INTEGER PRIMARY KEY, " \
	  "timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, "\
      "php_self TEXT , " \
      "remote_addr TEXT, " \
	  "http-x-forwarded-forr TEXT, " \
      "http_host TEXT, " \
      "request_uri TEXT, " \
      "http_referer TEXT, " \
      "http_user_agent TEXT)"
cursor.execute(sql)
sql = "CREATE INDEX IF NOT EXISTS idx_timestamp ON cwcsqlite (timestamp, id)"
cursor.execute(sql)
sql = "CREATE INDEX IF NOT EXISTS idx_date_ip ON cwcsqlite (date(timestamp), remote_addr)"
cursor.execute(sql)
sql = "CREATE INDEX IF NOT EXISTS idx_date_uri ON cwcsqlite (date(timestamp), request_uri)"
cursor.execute(sql)
connection.commit()
# Verbindung beenden
connection.close()
# HTML
print("<html>")
print("<head>")
print('<meta name="robots" content="noindex"/>')
print("</head>")
print("<body>")
print("Datenbank wurde erzeugt")
print("</body>")
print("</html>")
