<!DOCTYPE html>
<html>
    <head></head>
    <body>
    <style>
        .result_list {}
        .result_list ol {
            margin: 0;
        }
        .result_list ol li:first-child {
            padding: 0;
        }
        .result_list ol > li {
            padding-top: 140px;
        }
        .result_list ol li ul {
            float: left;
        }
        .result_list ul li {
            list-style: none;
        }
        .result_list ul li:first-child {
            padding-top: 10px;
        }
        .result_list ul ul {
            padding: 0; padding-top: 10px; padding-left: 5px;
        }
        .result_list ul ul li {
            display: inline;
        }
    </style>
        <div class="result_list">
            <ol>
                <li>
                    <img src=../resources/images/Book.png style="float: left;">
                    <ul>
                        <li>Pippo, Max</li>
                        <li><a href="" style="text-decoration: none; color: blue;">Ciao pippo</a></li>
                        <li>Frollini production, 2001</li>
                        <li>
                            <ul>
                                <li><a href="" style="padding: 5px; background-color: #8abb21; border-radius: 3px;">Prenota</a></li>
                                <li style="padding: 5px; background-color: #DDD; border-radius: 3px;">Copie disponibili: n</li>
                                <li style="padding: 5px; background-color: #DDD; border-radius: 3px;">Prenotazioni: n</li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <img src=../resources/images/Book.png style="float: left;">
                    <ul>
                        <li>Gesu cristo</li>
                        <li><a href="">Bibbia</a></li>
                        <li>Dio, 0001 ac</li>
                    </ul>
                </li>
                <li>
                    <img src=../resources/images/Book.png style="float: left;">
                    <ul>
                        <li>Douglas</li>
                        <li><a href="">Guida intergalattica per autostoppisti</a></li>
                        <li>DONT PANIC, 300k al</li>
                    </ul>
                </li>
            </ol>
        </div>
    </body>
</html>