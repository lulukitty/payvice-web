<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PushPayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'total:pushPay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'EOD Notifications of all Total Payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        * GET all Payment from TAMS that have not been pushed
        */
        $client = new \GuzzleHttp\Client();
        $res = $client->post('http://197.253.19.78/tams/snepco/totalPay.php', ['json' => time()]);

        if ($res->getStatusCode() == 200) {

            $response = json_decode($res->getBody()->getContents(), true);

            foreach ($response as $payment) {
                /*
                * Add up payment per vendor
                * Push to TOTAL as bulk
                */

                

            }


            $this->info('Worked');

        }
    }
}
