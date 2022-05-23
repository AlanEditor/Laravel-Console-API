<?php

namespace App\Console\Commands;

use App\Models\Moeda;
use Illuminate\Console\Command;

class checkAvgBigPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkAvgBigPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se existe um valor que seja 0.5% menor do que o preço médio';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Captura o código (symbol) digitado no console formatando em caixa alta
        $moeda = strtoupper($this->ask('Qual é o código (symbol) da criptomoeda?'));

        //Consultar o banco para ver se existem registros com aquela moeda
        $consultaBD = Moeda::where('symbol', $moeda)->count();

        if($consultaBD < 100){
            return $this->info('Moeda inválida ou sem registro no banco de dados. Por favor, execute o comando: saveBidPriceOnDataBase');
        }
        else
        {
            /*
            //Consulta a API para pegar o valor atual
            $url = 'https://api.binance.com/api/v3/ticker/price?symbol='.$moeda;
            $api = new saveBidPriceOnDataBase();
            $valor = $api->consultar($url);

            //Request ao banco de dados
            $preco = [];
            $conteudos = Moeda::where('symbol', $moeda)->get();
    
            //Adiciona os valores ao array
            foreach($conteudos as $conteudo)
            {
               $conteudo->price;
               array_push($preco, $conteudo->price);
            }
    
            //Calcula o preço médio e formata
            $precoMedio = array_sum($preco) / 100;
            $precoMedio = number_format($precoMedio, 2, '.', '');

            //Calcula a porcentagem e formata
            $porcentagem = $precoMedio * 0.05;
            $porcentagem = number_format($porcentagem, 2, '.', '');

            //Valor atual
            $atual = $valor['price'];
            
            if($atual < ($precoMedio - $porcentagem))
            {
               return $this->alert('O PREÇO ESTÁ MENOR QUE A MÉDIA - APROVEITE E COMPRE');
            }
            else
            {
                return $this->info('o valor da média entre os ultimos 100 é maior que o valor atual');
            }
            */
            

            //CASO O ÚLTIMO SEJA REFERENTE AO ULTIMO VALOR E NAO AO ATUAL

            //Request ao banco de dados
            $preco = [];
            $conteudos = Moeda::where('symbol', $moeda)->get();
    
            //Adiciona os valores ao array
            foreach($conteudos as $conteudo)
            {
               $conteudo->price;
               array_push($preco, $conteudo->price);
            }

            //Recebe o ultimo valor do array
            $atual = end($preco);

            //Calcula o preço médio e formata
            $precoMedio = array_sum($preco) / 100;
            $precoMedio = number_format($precoMedio, 2, '.', '');

            //Calcula a porcentagem e formata
            $porcentagem = $precoMedio * 0.05;
            $porcentagem = number_format($porcentagem, 2, '.', '');

            if($atual < ($precoMedio - $porcentagem))
            {
               return $this->alert('O PREÇO ESTÁ MENOR QUE A MÉDIA - APROVEITE E COMPRE');
            }
            else
            {
                return $this->info('o valor da média entre os ultimos 100 é maior que o valor atual');
            }
            
        }
    }
}
