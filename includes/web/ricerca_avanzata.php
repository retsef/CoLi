<h2 class="page_header">Ricerca avanzata</h2>
<form action="./index.php?page=risultati_ricerca" method="post">
    <div class="input_field" style="margin-top: 10px;">
    <div class="frame">
        <div class="frame_header">
            <p>Includi i seguenti campi</p>
            <select name="search_option" class="input_select">
                <option value="AND" selected="selected">Tutti (AND)</option>
                <option value="OR">Almeno uno (OR)</option>
                <option value="AND NOT">Nessuno (NOT)</option>
            </select>
        </div>
        <div class="row">
            <select name="search_target" class="input_select">
                <option value="autore" selected="selected">Autore</option>
                <option value="titolo">Titolo</option>
                <option value="editor">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_group_form" style="float: none;">
        </div>
        <div class="row">
            <select name="search_target" class="input_select">
                <option value="autore">Autore</option>
                <option value="titolo" selected="selected">Titolo</option>
                <option value="editor">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_group_form" style="float: none;">
        </div>
        <div class="row">
            <select name="search_target" class="input_select">
                <option value="autore">Autore</option>
                <option value="titolo">Titolo</option>
                <option value="editor" selected="selected">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_group_form" style="float: none;">
        </div>
    </div>
</div>
<div>
    <button type="submit" name="submit" class="btn btn_submit" style="margin-top: 5px;">Cerca</button>
</div>
</form>