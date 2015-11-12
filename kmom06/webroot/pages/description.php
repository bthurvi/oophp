<h1>Redovisningar</h1>

<h4>Kmom05 - <a href="http://dbwebb.se/oophp/kmom05">Lagra innehåll i databasen</a></h4>

<p>Med alla moduler i anax känns det bra. Jag börjar få en känsla för hur man kan strukturera sin kod i klasser och moduler. Däremot saknar jag fortfarande uppdelningen i mvc (jag tycker det känns fel med massor av presentationskod inne i klasserna).  Urbax, dvs min version av anax, tycker jag känns kompentent och bra. Det enda som jag funderat på, som kanske saknas, är en modul för användarhantering. Där man kunde skapa/radera en  användare, och redigera dess profil. I övrigt är jag rätt glad för anax. Speciellt nöjd är jag med innehållshanteringen och den dynamiska navigationsmenyn, <b>som med automatik skapar nya menyalternativ för alla de webbsidor och bloggposter som lagras i databasen!</b> </p>



<p>Nedanstående text skrev jag parallellt med att jag kodade. Det var enkelt för mig på det sättet - men texten blev relativt stolpig. 
    Betrakta den gärna som mina minnesanteckningar: </p> 

<p>Jag inledde med att justera en bugg ifrån förra momentet. Om en användare gav sökkriterier som innebar att inga filmer matchade fick man upp flera varningar och felmeddelanden.
    Nu har jag justerat så att det istället blir en utskrift. Felet bestod i ett metodanrop med tomt resultset. Jag lade till en kontroll för att se om ett tomt resultatset returnerades från
    databasen - i de fallen sker inget metodanrop utan endast en text som informerar om att inga resultat kunde hittas skrivs ut.</p>

<p>När buggen väl var  fixad läste jag igenom instruktionen för aktuellt moment.</p>

<p>Därefter gjorde jag  övningarna med CTextFilter. Det var bara ladda hem färdig kod och köra. Jag fick inga problem och gjorde därför även extrauppgifterna. Det gick snabbt - några timmar bara.</p>

<p>Sedan gav jag mig i kast med att skapa en klass för innehåll i databasen, CContent. Men först behövde jag förstå vad jag skulle göra. 
    Jag fick om läsa uppgifterna flera gånger för att inse vad uppgiften bestod i. 
    Jag tolkade det som att jag skulle följa guiden fast göra en objektorienterad lösning. 
    Det stod det inget om var behandling av POST/GET-variabler skulle ske - så jag tolkade det som att jag fick behandla dessa var jag ville. 
    Jag lade dem  i sidkontrollerna för att hålla klassens kod renare.</p>

<p>Därnäst skapade jag klassen CContent med metoderna: konstruktor, reset, add, uppdate och delete:</p> 
  
<p>Konstruktorn fick en options parameter (tyckte att klassen blev mer generell då). 
    Den ansluter via CDatabase och parametrarna till databasen.</p> 

<p>Metoden reset hanterar återställning av tabellerna content och users i databasen. 
    Den är skriven så att den hanterar både inställningar både för lokal utveckling och för driftsmiljön. 
    Jag har justerat både i config-filen och i metoden så att detta fungerar smidigt. </p>

<p>Skrev sedan en sidkontroller för att lägga till innehåll (förutsatt att man är inloggad) genom att ange titel och typ av innehåll, dvs page eller post.</p>
    
<p>Fyller på med mer information gör man genom att editera/uppdatera. 
    Det är en enklare lösning för mig som programmerare - men sannolikt besvärligare för brukaren. 
    I ett produktionssystem (eller kanske till projektet i denna kurs) skulle jag ha valt att göra två olika sidkontroller,
    en för att skapa blogposter och en för att skapa sidor, men just nu får det duga så här.</p>

<p>Fixade sedan metoden add så att det fungerar att spara. 
    Här var jag tvungen att minnas ihåg hur klassen CDatabase och prepared statements fungerar. 
    Det var en bra repetition - tänk vad man glömmer detaljer snabbt.</p>

<p>Nästa del jag gav mig i kast med var att editera. Där skapade jag en kontrollen av giltigt ID-värde genom en metod: validContentId i klassen CContent. 
    Dessutom skullde det kontrolleras att användare var inloggad - det var som vanligt lite trixande innan logiken fungerade. Men det gick efter lite jobb.</p>

<p>Så kopierade jag editera och gjorde om koden till en sida för att radera poster. Det gick enkelt, det mesta av koden var ju redan skriven.

<p>Därnäst löste jag extrauppgift 1: Lade till en slugify-metod som anropas när användaren skapar nytt innehåll.</p>

<p>Sedan extrauppgift 2: För att låta allt innehåll ha en ägare lade jag till fältet author i content-tabellen. 
    Där sparas författarens akronym (vilket antas vara den inloggade användaren) när nytt innehåll skapas.. 
    Akronymet är satt unikt i users-tabellen därför går det fint att använda som identifierare.</p>

<p>Skapade sedan en sida, page.php som använder klassen CPage för att visa webbside-innehåll från databasen. 
    Utifrån den givna exempelkoden gick det snabbt och enkelt. Bara att lägga in den i en klass och köra. 
    Jag valde att låta klassen ha två egenskaper: den ena håller anslutningen till databasen och den andra har en instans av CTextfilter. Tyckte att det gav en enkel lösning.</p>

<p>Sidkontrollern blogg.php och klassen CBlogg som jag skapade för att visa ett blogg-innehåll påminde mycket om föregående arbetsuppgift,  med page. 
    Det gick i alla fall enkelt och smärtfritt. En reflektion: eftersom att klasserna CBlogg och CPage påminnner väldigt mycket om varandra - skulle det vara 
    möjligt att göra en basklass som sedan CBlogg och CPage ärver egenskaper och metoder ifrån. Det skulle spara några rader kod. 
    Men eftersom vi (ännu) bara har två typer av innehåll så tyckte jag inte att det var värt det jobbet. Om behov uppstår så gör jag det då.</p>  

<p>Lade så till så att det visas vem som författade artikeln (Extrauppgift 1). Fixade även så att CConten kan hantera kategorier (Extrauppgift 2). </p>

<p>Kodande slutligen så att att navbaren automatiskt infogar länkar till alla blogg och webbsidorsidor i databasen. 
    - Jag valde att tolka extrauppgift 1 och extrauppgift 2 ifrån CPage och CBlogg på det sättet.</p>
    
<p>Här fick jag  fundera lite över hur jag skulle bygga den flerdimensionella arrayen. Men jag lyckades förvånansvärt snabbt (typ 3 timmar). 
    Det är, i mitt tycke, härligt att se att menyn  automatiskt uppdateras när man lägger till nytt innehåll.</p> 

<p>Lite stolt är jag allt över menyn. Det är väl kanske inte alldeles trivialt?. Egentligen borde jag skriva om navigationen till en klass, 
    så att den blir  enklare att återanvända nästa gång. Men det får vi ta då. Jag tycker att jag i det här momentet har lärt mig en 
    stimulerand lösning: kod som använder några klasser för att ladda databasinnehåll till en dynamisk navigiationsmeny. Mycket inspirerande. Kul!</p>

<p>Källkoden till denna webbplats ligger ute på GitHub 
    du hittar den <a href="https://github.com/bthurvi/oophp">här</a>.</p>

<p>&nbsp;</p>
<hr>



<h4>Kmom04 - <a href="http://dbwebb.se/oophp/kmom04">PHP PDO och MySQL</a></h4>

<p>Moment var relativt omfattande och innebar en hel del jobb. I alla fall om man, som jag, valt att att göra alla uppgifter. Totalt har jag:</p>
<ul>
    <li>Gått igenom den funktionsbaserade guiden om film-databasen.</li>
    <li>Skapat en dynamisk rullgardins-navigationsmeny i tre nivåer.</li>
    <li>Tagit fram en ny design (template + css).</li>
    <li>Tillverkat testsida.</li>
    <li>Skapat en objektorienterad film-sök-sida.</li>
    <li>Samt gjort de objektorienterad status-logga in-logga ut sidorna.</li>
</ul>

<p>Med det i åtanke är det kanske är naturligt att det krävdes mer tid än jag initialt trodde?</p>

<p>Mer jobb innebär ofta i mer inlärning - därför har det kanske varit bra att det krävts mycket arbete. Det är, i alla fall i mitt tycke, viktigt att bära kunskapsflaggan högt!</p>

<p>Nog om detta. Nu är dags för själva redovisningstexten:</p>

<p>Att jobba med PHP PDO kändes bra för mig. Men eftersom jag har jobbat med det tidigare har det säkerligen påverkat hur svårt/lätt jag tyckt att det varit och därigenom 
    påverkat mitt känslointryck.</p>


<p>Jag följde guiden med <a href="http://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql">filmdatabsen</a> (eftersom det stod att man skulle det) alla moment kom inte riktig i 
   den ordning som jag ville. Därför fick jag hoppa runt lite i instruktionen vilket kändes lite besvärligt. Men eftersom jag först skum-läste igenom hela guiden så gick det ändå hyffsat. 
   Den ordning som jag valde att lägga upp arbetet på innebar  att jag direkt började med klassen CDatabase som Mikael hade introducerat först i mitten av texten. Min initiala arbetsgång var: 
   lägg in databas-anslutnings-parametrarna i config, skapa klassen, fyll databasen och därefter testa så att det fungerade.</p>

<p>Jag utökade medlemsfunktionen ExecuteSelectQueryAndFetchAll med möjligheten att returnera ett frågeresultat eller en komplett HTML-tabell. Det innebar att jag lade till
    en privat funktion som jag kallade generateHTMLtableResult.</p>

<p>Vid denna tidpunkt insåg jag att det skulle bli många sidor och meny-alternativ, om jag genomförde allt som stod i instruktionen. Då mindes jag  något om en extrauppgift
i form av en drop-down-meny, därför gjorde jag ett nytt hopp för att titta på den delen.</p>

<p>I <a href="http://dbwebb.se/coachen/en-navbar-med-drop-down-meny-i-ren-html-och-css">första delen</a> , som jag läste, handlade det bara om HTML-strukturen och CSS:en. 
    Själva stylingen ville jag lägga till efter jag väl hade menyn på plats. Därför läste jag igenom delen om att
    <a href="http://dbwebb.se/coachen/skapa-en-dynamisk-navbar-meny-med-undermeny-via-php">skapa en dynamisk meny med undermeny via PHP</a>. Med denna information i färskt minne
valde jag att uppdatera funktionen GenerateMenu i klassen CNavigation så att den klarar att hantera undermenyer. För att inte strula till koden det valde jag först att skapa ett
ett testprogram . Det blev två klasser: CNavigation och CDropDownMenu.  Efter en del jobb så fick jag det att fungera med både html-genereringen utifrån nästlade arrayer 
och med den CSS som jag önskade. Extra intressant var att jag var tvungen att använda SPL-klassen RecursiveItterator för att få markeringen av aktivt menyalternativ att fungera. Kul! 
Därefter skapa de jag en ny branch i git, lade in klasserna i kmomo04-projektet, fixade menyn och gjorde om hela stylingen för siten (med en ny template och en ny css-fil). Sedan merge:ade jag
den branchen tillbaka med master:n. Det var lärorikt och gav god erfarenhet tycker jag.</p>

<p>När menyn och den nya designen väl var klar återvände jag till arbetet med att följa guiden om <a href="http://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql">filmdatabsen</a>.</p>

<p>Övningar med CDatabase var en ganska seeeg och tråkig uppgift tycker jag. Den är säkert bra för dem som inte jobbat igenom och förstått guiden om filmdatabasen.
   Jag tyckte att jag förstår guiden väl och därför uppfattar jag denna uppgift som lite onödig. Men hursomhelst, man får inte alltid göra bara det som är roligt.
   Jag tuggade mig därför igenom uppgiften, på en kväll samtidig som jag såg hockey (det blev det lite roligare, fast kanske inte riktigt lika koncentrerat).</p>

<p>Uppgiften <a href='http://dbwebb.se/uppgift/generera-en-html-tabell-fran-en-databastabell-anvand-sokning-sortering-och-paginering'> Generera en HTML-tabell från en databastabell, använd sökning, sortering och paginering </a> gick bra. Inga större problem faktiskt. 
    I mitt utförande blev det en samling statiska metoder innuti en klass. Absolut möjligt att diskutera om det är bästa lösningen - men jag tyckte i alla fall att det blev enkelt.</p>
    
<p>Att <a href='http://dbwebb.se/uppgift/skapa-en-klass-for-anvandarhantering-cuser'>skapa en klass för användarhantering, CUser</a> blev, för mig, en singelton-klass. Jag ville nämligen testa
    deignmönstret för att bara tillåta inloggning av en användare i taget (vilkent eliminerar risken för radering/överskrivning av varandras ändringar i ett fleranvändarsystem).
    Så har jag skrivit klassen just nu. Vi får se om jag ändrar tillbaka klassen till en vanligt klass framöver. Tiden får utvisa.</p>

<p>De fördelar jag, hittils sett, med Anax-konceptet/ramverket, är att dete blir  enkelt kan återanvända klasserna i nya projekt. Det verkar smidigt.
   Däremot är jag lite tveksam till hur praktisk det är med blandningen med logik och html-kod i är i klass-filerna. 
   Därför skall det bli intressant att se om det blir 'renare' och mer strukturerad kod i nästa kurs, som lär handla om MVC.</p>

<p>&nbsp;</p>
<hr>


<h4>Kmom03 - <a href="http://dbwebb.se/oophp/kmom03">SQL och databasen MySQL</a></h4>


<p>Det här tycker jag var ett trevligt kunskapsmoment! Men det kanske beror på att jag har arbetat med databaser en del tidigare i form av access, mysql och lite SQLserver. 
    I de fall man har  tidigare erfarenhet blir ju ofta saker och ting lite enklare…<br>Hursomhelst här följer en liten text om vad jag tyckte, 
    hur jag jobbat och vad jag lärde mig av delarna i momentet:</p>

<h5>Kom igång med databasen MySQL och dess klienter</h5>

<p>På datorn som jag jobbar med laborationerna (kunskapsmomenten) hade jag tidigare installerat bitnami joomla. När jag skulle börja med denna laboration kunde jag dock inte minnas lösenorden. 
    För att göra det så enkelt och snabbt som möjligt för mig valde jag därför att avinstallera xampp/joomla och ersätta det med wamp. Installationen var inga problem förutom att jag fick 
    leta efter sökvägen till come l(jag den som default browser).</p>

<p>När jag skulle starta så visade det sig att wamp krockade med IIS varpå jag behövde aktivera IISkontrollpanen (i aktivera windowsfunktioner) och sedan ställa om porten för IIS:en 
    (jag ville att wamp skulle använda port 80 och IIS port 8080). När väl det var fixat funkade det som en dans.</p>
    
<p>Att starta MySQL CLI var inga problem när man tittade på bilden som mos har publicerat. När man vet att det man skall leta efter kallas MYSQL Console är det 
    ju faktiskt väldigt enkelt.</p>

<p>Att visa databser, skapa databas, sätta aktiv databas, skapa tabell i CLI var inga problem. Däremot fungerade inte syntaxen INSERT INTO Test VALUES(1), (2), (3); 
    Istället fick jag köra insert into tre gånger - men det fungerade fint. Att visa inlagda värden och ta bort databasen test gick även det bra.Det kändes helt ok att 
    använda den textbaserade klienten.</p>

<p>phpMyAdmin har jag använt förut. Det känns alltid relativt enkelt och smidigt tycker jag. Så även denna gång.</p>

<p>Därefter laddade jag ner och testade mysql workbench. Jag provade miljön genom att göra samma operationer som ovan (dvs skapa databas, tabell, fylla den 
    med några  värden och sedan radera databasen. För mig så kändes det lite besvärligt att skriva och exekvera SQL-satserna. Jag gillar nog de två föregående 
    klienterna lite mer (men kanske beror  det på att jag inte har använt workbench tidigare).</p>
    
<p>Efter att ha  bekantat mig lite med de tre klienterna, är det som jag (fortfarande) gillar bäst fortfarande phpMyAdmin, eftersom det är enkelt att jobba i.</p>

<h5>BTH's labbmiljö för databasen MySQL</h5>

<p>Att koppla upp sig via putty och msql cli gentemot labbmiljön gick smidigt. Det som var besvärligast var faktiskt att hitta den sida i studentportalen där man skapade sitt msql-lösenord...</p>
    
<p>Klienten phpMyAdmin var heller inga problem att jobba i. Det var precis som jag gjort förut. En fördel med denna klient tycker jag är det grafiska användargränssnittet. 
    Det snabbar upp och föreklar en del operationer.</p>

<p>MySql workbench gick inte att få att fungera gentemot studentservern. Jag kontaktade Mikael om detta via forumet och han svarade att det troligen vara en konfigurering i 
    servern som behövde ändras för att alla skulle få  behörighet att ansluta via workbench. I och med det svaret så släppte jag den klienten och gick vidare med nästa del.</p>

<h5>Kom igång med SQL</h5>

<p>Dettta var i mitt tycke den trevligaste och viktigaste delen i kunskapsmomentent. Jag fick tillfälle att repetera tidigare SQL-kunskaper och upptäkte till min förtjusninga att 
    flera SQL-uttryck blev både enklare och klarare. Jag insåg t.ex. tydligare än vad jag gjort tidigare styrkan och smidigheten med vyer.</p>

<p>Jag tilltalades av förklaringsmodellen där inner join on jämfördes med att ange flera tabeller i en select med where-villkor - för mig var det en tydlig och bra jämförelse.</p>

<p>Även avsnittet om teckenkodning var klart och tydligt skrivet. Det brukar ju som regel bli en det problem med de svenska tecknen. 
    Då är det enkelt att kunna hitta alla inställningar man behöver komma ihåg ett ställe!</p>

<p>Avsnittet om lagringsmotorer förklarade lite om innoDB och MyISAM (även om det var en ganska ytlig förklaring).  Det var något jag tidigare inte riktigt hade koll på.</p>

<p>Jag vet egentligen inte om jag tycker att det vara något i denna övning som var extremt svårt, snarare lagom. Men kanske beror det på att mycket var tydligt förklarat.
    Av tidigare erfarenhet vet jag dock att man kan få klura en hel del innan man får ut den data man vill. Fast ju mer man har jobbat med databaser desto enklare brukar det ju bli…</p>

<h5>Sammanfattning</h5>

<p>Totalt sett stötte jag inte på några oöverstigliga problem (förutom workbench och studentservern). Det mesta gick relativt enkelt att lösa. 
    Jag tycker att det har gett mig mer erfarenhet av databaser och SQL samt att jag lärt mig lite mer. Det var helt enkelt ett, i mina ögon, trevligt moment.</p>

<p>Källkoden till denna webbplats ligger ute på GitHub 
    du hittar den <a href="https://github.com/bthurvi/oophp">här</a>.</p>

<p>&nbsp;</p>
<hr>

<h4>Kmom02 - <a href="http://dbwebb.se/oophp/kmom02">Objektorienterad programmering i PHP</a></h4>

<p>Jag känner ganska väl till objektorienterade koncept och programmeringssätt. Därför valde jag att endast skumläsa guiden oophp20 och sedan ge mig i kast med uppgifterna. Jag tror att jag har lyckats hyfsat med båda - men vi får se vad den som bedömmer mina lösningar säger...</p>

<p>Tärningsspelet 100 skulle fungera så att en spelare kunde spela. Som extra uppgifter kunde man göra så att flera spelare kunde spela mot varandra, eller så att man kunde spela mot datorn. Jag valde att göra en lösning som förenar dessa krav på en gång genom att låta besökaren ange hur många mänskliga respektive datorspelare (AI:n) som skall spela.</p>

<p>Utifrån användarens val skapas instanser av klasserna, CPlayer, C3Player, C15PointPlayer. Klassen CPlayer representerar en mänsklig spelare. Klasserna C3Player och C15PointPlayer ärver av klassen CPlayer samt utökar den med olika artificiell intelligens. Instanserna lagras sedan i en medlemsvariabel (array) i klassen CGame som representerar hela tärningsspelet. CGame har även en artificiell tärning i form av en instans av klassen C6Dice.</p>

<p>För att webbplatsen skall kunna hålla reda på hela spelet mellan page-reloads så lagras hela spelets instans i en sessionsvariabel av <a href="?p=code&amp;path=webroot/pages/dicegame.php">dicegame-sidan</a></p>

<p>Samtliga klasser ligger sorterade i <a href="?p=code&amp;path=src/dicegame/">dicegame-mapp</a>(de laddas av AutoLoaderns callback funktion).</p>

<p>Jobbigast med själva uppgiften var faktiskt inte objektorienteringen utan var nog snarare meny och spellogiken. Personligen tycker jag att det ibland kan vara lite besvärligt att avgöra via if-satser och villkor när olika saker skall ske och inte.</p>

<p>Kalenderuppgiften “månadens babe” (märkligt nästan sexsistiskt namn förrresten) var i mitt tycker något enklare. Den löste jag endast via två klasser: CCalendar och CsvMonths. CsvMonths innehåller endast svenska namn på månaderna (jag valde en sådan lösning istället för att förlita mig på locale-funktionen.) CCalendar håller reda på aktuell månad och år, plockar fram datumen samt skapar själva html-koden med bild och tabell.  Via lite kod från <a href="http://victor.se/bjorn/holidays.php">Björn Viktor</a> färgas dessutom  alla röda dagar under månaden/året.</p>

<p>Sammanfattningsvis kan man säga att jag hade några få besvär,svårigheter och problem med logiken men löste det. Kursmomenten tycker jag har gett mig ökad erfarenhet i objektorienterad programmering Resultatet tycker jag blev hyfsat (även om koden säkerligen går att förfina, förenkla och göra elegantare). De lärdomar som dessa båda uppgifter har gett mig är ökad förståelse för variablers synlighet i samband med objektorienterad programmering (exempelvis parent:: och self::). Uppgifterna har även gett mig ökad erfarenhet av att få klass-instanser att samverka med varandra (som t.ex.C3Player och CDice). </p>

<p>Källkoden till denna webbplats ligger ute på GitHub 
    du hittar den <a href="https://github.com/bthurvi/oophp">här</a>.</p>

<p>&nbsp;</p>
<hr>

<h4>Kmom01 - <a href="http://dbwebb.se/oophp/kmom01">Kom igång med programmering i PHP</a></h4>

<p>Jag använder utvecklingsmiljön NetBeans till kodandet av uppgifterna i denna kurs.</p>
<p>Guiden 20 steg för att komma igång med PHP har jag i ärlighetens namn bara skummat igenom. Vid genomläsningen föreföll det inte vara särskilt mycket nytt för mig. Jag upplevde att jag kunde det mesta och valde därför att gå vidare med själva kodandet av anax.</p>
<p>Min version av anax valde jag att kalla för urbax, eller förkortat UV-ax. Där Ax-ändelsen kommer  från anax och UV är mina initialer. Som du som läser detta kan se ovan tillverkade jag även en egen logga och favicon till urbax. Eftersom jag råkar heta Urban blev loggan och faviconen inspierad av bebyggelse (Urban betyder ju även stad). Min tanke är att loggan eventuellt kan fungera att använda till kunskapsmomentet 07/10. Min tanke är nämligen att eventuellt byta ut RM Rental Movies till Rental accommodations, dvs hus och lägenheter. När jag kommer så långt i kursen får vi se hur och om det blir så... </p>

<p>Det enklaste sättet att bygga denna webbplats utifrån anax-basen hade naturligtvis varit att bara klona git-koden och sedan byta några namn. Men eftersom jag gärna vill ha koll på vad jag gör i koden så valde jag istället att bygga allt från grunden enligt mos guide. Lite mer jobb men mycket bättre förståelse enligt mitt sätt att se på saken. Samtidigt som jag följde guiden ändrade en del i css-en från anax, bytte typsnitt, ändrade menyutformning och valde att centrera vissa sidelement som rubriker och så. I övrigt tyckte jag att den vita designen fick vara kvar.</p>

<p>Själva strukturen i Anax trivs jag ganska bra med, men jag gjorde några ändringar till mitt urbax. Bland annat skapade jag en index-sida som inkulderar header, navigation och footer (så slipper jag ha med den koden i varje page-controller). Index-pagecontrollern styr via navigation.php vilket sid-innehåll som skall laddas. Innehållet till de olika sidorna (som ligger i pages-mappen) överförs där I(i navigation.php) till variabeln  jag content. En utskrift av innehållet i content sker sedan vid renderingen, dvs templatefilen (index.tpl.php). Eventuellt kan användandet av get-variabel för navigering innebära lite besvärligar rewrite-rules än vanligt när man tänker mvc (men om det blir aktuellt i den här kursen återstår att se). En annan anledning till att det blev en get-lösning beror nog på att guiden om de dynamiska navigationselementet (klassen cNavigation) var skriven på det sättet... </p>

<p>Det jag tycker att jag har lärt mig av det här kursmomentet är främst autoloaderfunktionen. <strong>spl_autoload_register</strong> hade jag inte hört talas om tidigare. Likaså var strukturen med en  callbackfunktion för att hantera aktiv sida i menyn ny för mig. Ett hyffsat smidigt förfaringssätt tycker jag.</p>

<p>Det gick bra för mig att inkludera source.php som en modul. först fick jag lov att lägga till en get-parameter i sökvägen för breadcrumben, mapparna och filerna eftersom jag använder mig av en index-sida med get parametrar. Jag fick även fixa lite med CSS-en för att få en snygg utskrift. </p>
  
<p>Efter uppladdningen av av detta, kmom01, gjorde jag även extrauppgiften med GitHub - eftersom jag ville påminna mig om det. Jag hade gjort det förr, någon gång, men glömt en del. Det sägs ju att repetition är kunskapens moder...</p>
