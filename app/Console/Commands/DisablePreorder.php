<?php

namespace App\Console\Commands;

use App\Product;
use App\Services\CartService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DisablePreorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disable:preorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable pre-order update quantity function';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        parent::__construct();
        $this->cartService = $cartService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $preorderProducts = Product::where('preorder', Product::ENABLED)->get();
        foreach ($preorderProducts as $preorderProduct) {
            if ($preorderProduct->deadline == Carbon::today()->toDateString()) {
                $this->cartService->delPendingPreorders($preorderProduct);
                $preorderProduct->update(['preorder' => Product::DISABLED]);
            }
        }
    }
}
