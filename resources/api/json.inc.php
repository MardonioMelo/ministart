<?php

# Saída da API
echo empty($exit) ?  "Erro ao selecionar ação!" : json_encode($exit);