
<h1 class="center">Sidan TEST - övningar med CDatabase</h1>

<!-- 

------------------------------ FÖRBEREDELSER -------------------------------------------------------------

1. Skapa databas och tabeller: Det görs via menyalternativet Filmdatabas -> Kom igång guide -> återställ

2. CDatabase finns redan - den klassen skapade jag när jag jobbade med guiden

3. Eftersom denna sida ligger i mitt urbax-ramverk så finns det redan en config-fil.

3.1 i config.php startar en namgvigen app via
    session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
    session_start();

3.2 i config.php definieras användare och lösenord via define('DB_USER', ... ); och define('DB_PASSWORD', ...); 

3.3 Array skapas med nödvändiga nycklar:

$urbax['database']['dsn']            = 'mysql:host=localhost;dbname=Movie;';
$urbax['database']['username']       = DB_USER;
$urbax['database']['password']       = DB_PASSWORD;
$urbax['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");


3.4 Funktionen dump deklareras i filen bootsrap.php 
(jag tyckte att det kändes bättre att lägga den där - ibland andra funktioner
i stället för
att lägga den i i config-filen - där jag bara vill ha inställningar)

4.1 Denna fil (som du nu läser i) är skapad

4.2 inkluderingen av config görs via ramverket urbax

4.3 Klassen CDatabase (och andra) laddas vid av spl_autoloaders callbak funktion

-->


<?php
// ------------------------------- ÖVNINGAR -----------------------------------------------------------------

// 1. Skapar objekt av klassen CDatabase:
$dbh = new CDatabase($urbax['database']);

// 2. Läste om  funktionen ExecuteSelectQueryAndFetchAll (som jag skrivit in tidigare)
 
// 2.1 ExecuteSelectQueryAndFetchAll tar maximalt fem parametrar (jag har utökat funktonen med ytterligare två)
//    den första är SQL-strängen (dvs SQL-frågan som skall köaras) med ev ? som skall kopplas till frågan 
//    näta parmeter är en array med de värden som skall 'bindas'/kopplas till sql-strängen (default är en tom array)
//    tredje parametern är en bool som anger ifall sql-frågan skall skrivas ut eller ej (default är false)
//    frärde parametern $asHTMLtable anger iifall resultatet från frågan skall returneras som en HTML-tabell (default är false)
//    femte paramentern $tableCSSid anger ev.css id för styling av tabellen (default är detta en tom sträng)

// 2.2 Det är endast första parametern som är obligatorisk - de övriga fyra är optionella

// 2.3 Metoden kan returnera ett mixed resultset eller en html-tabell beroende på vad jag sätter parametern $asHTMLtabl till

// 3 Skapar en fråga för att hämta alla filmer
$qry = 'SELECT * from Movie';

// 4. Kör frågan
$res = $dbh->ExecuteSelectQueryAndFetchAll($qry);

// 5. Dumpa resultatet
dump($res);

// 6. Antalet filmer som ligger i filmdatabasen är för närvarande fem (5).
//  detta antal kan förändras - men man kan alltid få fram aktuellt antal via kommandot count($res)...

// 7. ID:t för res[4] är fyra (4).
// kan erhållas med kommandot: echo $res[3]->id;

// 8. Aropar rowcCount
echo "rowCount: " .$dbh->RowCount();


// 8.1 Row cont returnerade 5.

// 8.2 Siffran referarar garanterat till antalet rader som påverkades av INSERT, DELETE och UPPDATE
//     samt för vissa databaser även SELECT - men det är pålitlig  (enligt manualen)

// 9. Läste om ExecuteQuery

// 9.1  Parametrarna är:
//      En sträng med SQL-frågan (med ?)
//      En array med parametrar som har argumenten som skall ersätta eventuella ?
//      En true/false som anger om SQL-frågan skall printas innan körning


// 9.2 Endast första parametern (SQL-frågan) är obligatorisk, övriga frivilliga

// 9.3 Metoden returnerar true eller false beroende på om frågan lyckades eller ej


// 10 En SQL-query för att lägga till en film
$qry = 'INSERT INTO movie(title,year) VALUES(?,?)';

// 11. Skapar en array som innehåller de värden för filmen som ska läggas in
$params = array('Terminator 5',2015);

// 12. Anropar ExecuteQuery() 
$res = $dbh->ExecuteQuery($qry,$params);

// 13. Använder dump() samt var_dump() för att skriva ut $res. 
dump($res);
echo var_dump($res);

// 13.1 dump returnerade 1 och var_dump returnerade bool(true)

// 13.2 Det betyder att insättningen lyckades

// 14. Läste om  CDatabase::LastInsertId() 

// 15. Anropa och skriv ut resultatet av LastInsertId()
echo "last insert id:" . $dbh->LastInsertId();


// 15.1 ID:t blev i detta fall 12


// 16. Skriver och kör delete-query
$qry = 'DELETE FROM movie WHERE YEAR = ?';
$params = array('2015');
$res = $dbh->ExecuteQuery($qry, $params);


// 17. Använder dump() och var_dump() 
dump($res);
var_dump($res);


// 17.1 Först returnerades false (men sedan ändrade jag frågan till litet fältnamn year och ett likhetstecken och då funkade det) sedan ändrade jag tillbaka

// 17.2 Att false returnerades beror på på att nått gick fel

// 18. Läste i CDatabase om ErrorCode() och ErrorInfo() 

// 19. Anropa och skriv ut resultatet av ErrorCode() och ErrorInfo().
echo "ErrorCode: " .$dbh->ErrorCode();
var_dump($dbh->ErrorInfo());

// 19.1 Felkod 42000 visas

// 19.2 42000 är ett vanligt SQLSTATE-fel 

// 19.3 Meddelandet säger att felet i närheten av likhetsteknen

// 20. Åtgärda felen i queryn ovan. Svara på följande frågor som kommentarer i test.php:

//20.1 Jag ändratde queryn till ett likhetstecken och sedan funkade det

// 21. Läste sedan i CDatabase om vad GetNumQueries() och GetQueries() gör.

// 22. Anropade GetNumQueries() och GetQueries()
echo "num queries: " . $dbh->GetNumQueries();
var_dump($dbh->GetQueries());

// 22.1 GetNumQueries() ger antalet frågor som körts 

// 22.2 GetQueries() visar vilka frågor som körts

// 23. Läste sedan om  CDatabase::Dump() 

// 24. Anropade Dump
echo "dbh dump: " .$dbh->Dump();

//24.1  Dump()skriver ut alla databasfrågor som html

// 25. Läste om CDatabase::SaveDebug() 

//26. Anropade SaveDebug() 
$dbh->SaveDebug();
        
// och skrev sedan ut sessionen 
echo "SESSION: <br>";
dump($_SESSION);

// 26.1 I sessionen sparas information av SaveDebug om vilka databasfrågor som körts 

// 26.2 Datan sparas under nyckeln Database

// 26.3  Om man  laddar om sidan så byggs den på med mer debug-info (när savdDebug körs) 








