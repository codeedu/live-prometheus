<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class PrometheusController extends Controller
{
    public function metrics(CollectorRegistry $registry)
    {
        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());
        header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        echo $result;
        die;
    }

    public function gauge(CollectorRegistry $registry)
    {
        $gauge = $registry->registerGauge('users', 'online', 'it shows online users', []);

        while (true) {
            $gauge->set(rand(100, 10000));
            sleep(5);
        }
    }

    public function counter(CollectorRegistry $registry)
    {
        $counter = $registry->registerCounter('sales', 'by_age', 'sales_by_age', ['age']);

        while (true) {
            $counter->incBy(rand(5, 10), ['16']);
            $counter->incBy(rand(1, 5), ['18']);
            $counter->incBy(rand(1, 5), ['20']);
            $counter->incBy(rand(1, 5), ['22']);
            sleep(5);
        }
    }

    public function responseTime(CollectorRegistry $registry)
    {
        $histogram = $registry->registerHistogram('app_api', 'response_time', 'response time of sales api', ['api'],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        while (true) {
            $histogram->observe(rand(1, 20), ['sales']);
            sleep(5);
        }
    }
}
