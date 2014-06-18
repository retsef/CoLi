<?php

include './db_manager.php';

$db = new db_manager('localhost', 'root', '', 'opac');
if($db->connect())
{
echo 'Acesso avvenuto con successo<br>';
if($db->tableExists('book'))
{

$db->select('book');
echo 'Attualmente ci sono '. $db->numResult(). "<br>";

echo 'Aggiunta libro in corso<br>';

$q = array(
    $_POST['Titolo'],
    $_POST['Autore'],
    $_POST['Casa_ed'],
    $_POST['Anno'],
    $_POST['ISBN']
);

if($db->insert('book', $q, "Titolo,Autore,Casa_ed,Anno,ISBN"))
    echo 'Inserimento avvenuto con successo<br>';
else
    echo 'Errore nell inserimento<br>';

$db->select('book');
echo 'Attualmente ci sono '. $db->numResult(). "<br>";

print_r($db->getResult());
} else {
   echo 'La tabella non esiste';
}

} else {
    echo 'Impossibile contattare MySQL';
}


