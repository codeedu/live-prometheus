<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Prometheus\CollectorRegistry;

class Metrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metrics:prometheus {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute tasks that generate metrics of Grafana';
    private $registry;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CollectorRegistry $registry)
    {
        parent::__construct();
        $this->registry = $registry;
    }

    public function usersOnline()
    {
        $gauge = $this->registry->registerGauge('users', 'online', 'it shows online users', []);

        while (true) {
            $gauge->set(rand(100, 1200));
            sleep(5);
        }
    }

    public function salesByCategory()
    {
        $counter = $this->registry->registerCounter('sales', 'by_category', 'Shows the sales by category',
            ['category']);

        while (true) {
            $counter->incBy(rand(5, 10), ['Eletronics']);
            $counter->incBy(rand(10, 40), ['Toys']);
            $counter->incBy(rand(1, 40), ['Home']);
            $counter->incBy(rand(10, 80), ['Sports']);
            sleep(5);
        }
    }

    public function salesByLeadsource()
    {
        $counter = $this->registry->registerCounter('sales', 'by_source', 'Shows the sales by leadsource',
            ['leadsource']);

        while (true) {
            $counter->incBy(rand(5, 10), ['FacebookAds']);
            $counter->incBy(rand(5, 10), ['GoogleAds']);
            $counter->incBy(rand(1, 10), ['Email Mkt']);
            $counter->incBy(rand(4, 8), ['Outros']);
            sleep(15);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');

        if ($type == "users-online") {
            $this->usersOnline();
        } elseif ($type == "sales-by-category") {
            $this->salesByCategory();
        } elseif ($type == "sales-by-leadsource") {
            $this->salesByLeadsource();
        }

    }
}
