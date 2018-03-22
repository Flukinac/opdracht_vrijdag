<html>                                      <!--html openings tag-->
    <head>                                  <!--head openings tag waarin javascript normaliter thuishoort-->
        <script>                            //javascript openings tag
            function saveShips(){                                                    //functie aanmaak
                var scheepsnaam = document.getElementById("scheepsnaam").value;     
                //datgene wat in de value van het element met het id scheepsnaam staat wordt hier in de var scheepsnaam gezet
                
                var scheepslengte = document.getElementById("scheepslengte").value;     
                var vaarsnelheid = document.getElementById("vaarsnelheid").value;       
                var kleur = document.getElementById("kleur").value;                 
                //hier staat hetzelfde als in de bovenste regel in de functie maar met andere variabelen en ids
                
                document.location = "test.php?scheepsnaam="+scheepsnaam+"&scheepslengte="+scheepslengte+"&vaarsnelheid="+vaarsnelheid+"&kleur="+kleur;  
                //in de url voor dit bestand worden de zojuist gemaakte variabelen gezet met een naam waardoor deze te GETTEN zijn 
            }
            function update(schipid){                                               //functie aanmaak met parameter schipid
                var scheepsnaam = document.getElementById("scheepsnaam").value;     
                //datgene wat in de value van het element met het id scheepsnaam staat wordt hier in de var scheepsnaam gezet
                
                var scheepslengte = document.getElementById("scheepslengte").value; 
                var vaarsnelheid = document.getElementById("vaarsnelheid").value;  
                var kleur = document.getElementById("kleur").value;                 
                //hier staat hetzelfde als in de bovenste regel in de functie maar met andere variabelen en ids
                
                document.location = "updateschip.php?scheepsnaam="+scheepsnaam+"&scheepslengte="+scheepslengte+"&vaarsnelheid="+vaarsnelheid+"&kleur="+kleur+"&id="+schipid; 
                //in de url voor het bestand updateschip worden de zojuist gemaakte variabelen gezet met een naam waardoor deze te GETTEN zijn 
                
            }
            function verwijder(schipid){                            //functie aanmaak
                document.location = "wisschip.php?id="+schipid;     
                //in de url voor het bestand wisschip wordt de variabele uit de parameter van de functie gezet  waardoor deze te GETTEN is 
            }
        </script>       <!--einde javascript-->
        
        <?php   //opening php
        
            $sn="localhost";            //localhost wordt als string in de variabele $sn gestopt
            $un="root";                 //root wordt als string in de variabele $un gestopt
            $pw="root";                 //root wordt als string in de variabele $pw gestopt
            $db="boten";                //boten wordt als string in de variabele $db gestopt
            
            $conn = new mysqli($sn, $un, $pw, $db); 
            // er wordt een connectie met de database gemaakt door een instantie $conn te maken van mysqli en de 
            // argumenten mee te geven die in bovenstaande variabelen staan
            
            $sql = "INSERT INTO boten(scheepsnaam, scheepslengte, vaarsnelheid, kleur) VALUES ('$scheepsnaam',".$_GET['scheepslengte'].",".$_GET['vaarsnelheid'].",'".$_GET['kleur']."');";
            //in de $sql wordt een string gestopt die voor mysql leesbaar moet zijn. het betreft een invoegend commando waarbij er in de tabel boten, in de kolomnamen
            //scheepsnaam, scheepslengte, vaarsnelheid, kleurmet een aantal waardes worden gezet. de concatenaties van php variabelen
            //zijn door GET uit de url gehaald met betreffende namen en als string in de sql string gezet door quotes.
            
            $alleSchepen = "SELECT * FROM boten;";  
            //hier wordt een string voor mysql in de variabele $alleschepen gezet. de string is een commando om alle rijen in deze variabele te zetten
            
            $delete = "DELETE FROM `boten` WHERE `scheepsnaam`";
            //hier wordt een string voor mysql in de variabele $delete gezet. de string is een commando om alles in de kolom scheepsnaam te deleten
            
            $conn->query($sql);
            //met de $conn instantie wordt een query gedaan op de database met de string die in $sql zit; 
            
            $results = $conn->query($alleSchepen);
            // de resultaten van de query $alleschepen worden in de variabele $results gezet.
            
            $wissen = $conn->query($delete);
            // de query $delete returned een boolean in de variabele $results.
            ?>
    </head> <!--sluiting head-->
    <body>  <!--opening body-->
        Schepen opslaan:            <!--pagina tekst te zien in de browser-->
        <input type="text" id="scheepsnaam" placeholder="scheepsnaam">
        <input type="text" id="scheepslengte" placeholder="scheepslengte">
        <input type="text" id="vaarsnelheid" placeholder="vaarsnelheid">
        <input type="text" id="kleur" placeholder="kleur">
        <!--hier worden 4 textinvoer velden in html gemaakt met ids die in de javascriptfuncties worden gebruikt-->
        
        <input type="button" onclick="saveShips()" value="Versturen"><br><br>
        <!--hier wordt een knop gemaakt die de functie saveships(zonder argument) in javascript aanroept-->
        
       Schepen updaten:
        <input type="text" id="scheepsnaam2" placeholder="scheepsnaam">
        <input type="text" id="scheepslengte2" placeholder="scheepslengte">
        <input type="text" id="vaarsnelheid2" placeholder="vaarsnelheid">
        <input type="text" id="kleur2" placeholder="kleur">
        <!--hier worden 4 textinvoer velden in html gemaakt met ids die in de javascriptfuncties worden gebruikt-->
        
        <input type="button" onclick="update(schipid)" value="Updaten"><br><br>
        <!--hier wordt een knop gemaakt die de functie update(met argument schipid) in javascript aanroept-->
        
                <?php
            echo "<ul>";
            //met php wordt er een unorded list opening tag naar de browser gestuurd als string
            
//            foreach($results as $result){     (((uitgecommente code)))
            
            while($row = $results->fetch_assoc()){
                //een while loop loopt zolang de fetch_assoc methode gevulde posities kan maken uit de variabele results
                //de fetch_assoc returned de opgehaalde rij uit de tabel en zet deze om in een assoc_array die in de variabele $row komt
                
                echo "<li>";
                //de ge-echode list tag zet een stip neer voor een opsomming
                
                echo $row['scheepsnaam'];
                //de variabele $row bevat een assoc_array met een key die scheepsnaam heet. de wwaarde achter deze key wordt ge-echood
                
                echo "<input type=button onclick=update(".$row['ID'].") value=Updaten>";
                //hier wordt een knop ge-echood die de bij een onclick event de functie update aanroept met het 
                //argument assoc_array $row en de positie ID wat de kolomnaam is in een tabel
                
                echo "<input type=button onclick=verwijder(".$row['ID'].") value=Verwijder></li>\n";
                //hier wordt een knop ge-echood die de bij een onclick event de functie update aanroept met het 
                //argument assoc_array $row en de positie ID wat de kolomnaam is in een tabel
  //          }
            }
            echo "</ul>";
            //met php wordt er een unorded list sluiting tag naar de browser gestuurd als string
        ?>
    </body> <!--sluiting body-->
</html> <!--sluiting html-->