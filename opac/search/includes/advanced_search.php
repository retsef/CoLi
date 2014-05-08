<h2 class="page_header">Ricerca avanzata</h2>
<form action="/~roberto/CoLi/opac/search/result_search.php" method="post">
<div class="input_field">
    <div class="frame">
        <div class="frame_header">
            <p>Includi i seguenti campi</p>
            <select name="search_option" >
                <option value="AND" selected="selected">Tutti (AND)</option>
                <option value="OR">Almeno uno (OR)</option>
                <option value="AND NOT">Nessuno (NOT)</option>
            </select>
        </div>
        <div class="row">
            <select name="search_target" >
                <option value="autore" selected="selected">Autore</option>
                <option value="titolo">Titolo</option>
                <option value="editor">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_form" style="float: none;">
        </div>
        <div class="row">
            <select name="search_target" >
                <option value="autore">Autore</option>
                <option value="titolo" selected="selected">Titolo</option>
                <option value="editor">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_form" style="float: none;">
        </div>
        <div class="row">
            <select name="search_target" >
                <option value="autore">Autore</option>
                <option value="titolo">Titolo</option>
                <option value="editor" selected="selected">Editore</option>
                <option value="ISBN">Codice ISBN</option>
                <option value="ISSN">Codice ISSN</option>
            </select>
            <input type="text" class="input_form" style="float: none;">
        </div>
    </div>
</div>
<div>
    <button type="submit" name="submit">Cerca</button>
</div>
</form>