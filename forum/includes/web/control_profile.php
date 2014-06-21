<?php
    //print_r($user);
?>
<div class="bucket">
    <form action="" method="post">
    <h4 class="page_header">Dati account</h4>
    <div class="input_field">
        <div class="row">
            <div class="colum">
                <p>Username <sup>*</sup></p>
                <input type="text" class="input_group_form" value="<?=$user['username'] ?>">
            </div>
            <div class="colum">
                <p>Email <sup>*</sup></p>
                <input type="text" class="input_group_form">
            </div>
        </div>
        <div class="row">
            <div class="colum">
                <p>Password <sup>*</sup></p>
                <input type="text" class="input_group_form">
            </div>
            <div class="colum">
                <p>Conferma Password <sup>*</sup></p>
                <input type="text" class="input_group_form">
            </div>
        </div>
    </div>
    <h4 class="page_header">Informazioni anagrafiche</h4>
    <div class="input_field">
        <div class="row">
            <div class="colum">
                <p>Nome</p>
                <input type="text" class="input_group_form" value="<?=$user['name']?>">
            </div>
            <div class="colum">
                <p>Cognome</p>
                <input type="text" class="input_group_form" value="<?=$user['surname']?>">
            </div>
        </div>
        <div class="row">
            <div class="colum">
                <p>Giggiole</p>
                <input type="text" class="input_group_form">
            </div>
            <div class="colum">
                <p>Frollini!</p>
                <input type="text" class="input_group_form">
            </div>
        </div>
    </div>
    <h4 class="page_header">Informazioni legali</h4>
    <div class="input_field">
        <div class="row">
            <div class="colum">
                
            </div>
        </div>
    </div>
    <h4 class="page_header">Indirizzo</h4>
    <div class="input_field">
        <div class="row">
            <div class="colum">
                
            </div>
        </div>
    </div>
    <h4 class="page_header">Numero di telefono</h4>
    <div class="input_field">
        <div class="row">
            <div class="colum">
                <p>Numero <sup>*</sup></p>
                <input type="text" class="input_group_form">
            </div>
        </div>
    </div>
    <div style="margin: 15px; margin-left: 80%;">
        <button class="btn btn_submit" >Aggiorna Profilo</button>
    </div>
    </form>
    
    <h4 class="page_header">Informazioni</h4>
    <p>Qui puoi modificare i dati del tuo profilo</p>
</div>

