
## Sobre o Sistema

Este sistema em console realiza uma consulta a API Binance, salva no banco de dados as últimas cem requisições em relação a criptomoeda desejada, realiza um calculo médio entre os valores e retorna um resultado dizendo se o último valor requerido é 0.5% menor em relação à média adquirida.

## Como Funciona?

Siga os passoa abaixo:


- Execute o comando: *php artisan saveBidPriceOnDataBase* 
- Digite a criptomoeda desejada - Exemplo.: BTCUSDT
- Após o processo de registro ser completado, digite:  *php artisan checkAvgBigPrice*
- Digite a criptomoeda desejada - Caso esta não esteja cadastrada no banco de dados, será necessário rodar o primeiro comando e digita-lá.
- O sistema irá retorna o resultado.

