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
        <div class="row input">
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
    <div>
        <h3 class="page_header">Istruzioni</h3>
        <p>
            Da questa pagina puoi costruire una ricerca complessa, utilizzando diversi campi a tua disposizione. Seleziona un campo di ricerca dalla tendina "Tipo di campo", quindi inserisci o seleziona il testo da ricercare nel box accanto alla tendina. Per alcuni campi di ricerca (ad es. Autore, Classe, Soggetto), iniziando a scrivere il testo da ricercare potrebbe comparire una tendina di autocompletamento, da cui puoi selezionare una delle voci presenti nel catalogo.
            Puoi rimuovere o aggiungere un qualsiasi campo di ricerca, che può essere usato più volte e collegato agli altri tramite operatori booleani. Scegliendo l'operatore AND, i risultati della ricerca mostreranno documenti del catalogo che contengono tutti i valori inseriti; scegliendo l'operatore OR, sarà sufficiente che i documenti contengano almeno uno dei valori inseriti; con l'operatore NOT verranno esclusi dai risultati tutti i documenti che contengono quel valore. È possibile costruire ricerche complesse aggiungendo gruppi di campi al cui interno utilizzare diversi operatori booleani. I gruppi sono legati tra loro tramite l'operatore AND, ovvero i risultati dovranno rispettare tutte le condizioni di ricerca inserite.
            Prima di compiere la ricerca cliccando il pulsante "Cerca", puoi scegliere come dovranno essere ordinati i risultati ottenuti e quanti documenti mostrare per pagina.
        </p>
    </div>
</form>