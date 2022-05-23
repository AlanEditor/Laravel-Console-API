<?php

namespace App\Console\Commands;

use App\Models\Moeda;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class saveBidPriceOnDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saveBidPriceOnDataBase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Salva os ultimos cem dados da criptomoeda desejada';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Captura o código (symbol) digitado no console formatando em caixa alta
        $moeda = strtoupper($this->ask('Qual é o código (symbol) da criptomoeda?'));

        $url = 'https://api.binance.com/api/v3/ticker/price?symbol='.$moeda;

        //Chama o método que faz a consulta à API
        $cripto = $this->consultar($url);

        //Se existir alguma mensagem de erro, ele retorna uma mensagam ao usuário
        if(key_exists('msg', $cripto))
        {
            return $this->info($cripto['msg'] = 'Por favor, informar o código correto');
        }
        else
        {
            //Consultar o banco para ver se existem registros com a moeda
            $consultaBD = Moeda::where('symbol', $moeda)->count();

            //Exclui os ultimos cem registros feitos e depois atualiza novamente
            if($consultaBD >= 100){ Moeda::where('symbol', $moeda)->delete(); }

            $this->info('Salvando os últimos 100 registros');
            return $this->save($url);
        }
        
    }


    public function save($url)
    { 

        //Progress Bar
        $bar = $this->output->createProgressBar(10);
        $bar->start(100);

        //Cadastra os cem ultimos resutados
        for($i = 0; $i < 100; $i++)
        {
            $cripto = $this->consultar($url);
            Moeda::create($cripto);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        return $this->info('Salvo com sucesso');
        
    }

    //Funcao que consulta a API
    public function consultar($url)
    {
        $response = Http::get($url)->json();
        return $response;
    }
}
