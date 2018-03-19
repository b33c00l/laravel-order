<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Import;
use App\ImportItem;
use App\Jobs\ProccessGame;
use App\Platform;
use App\Product;
use App\Services\UploadToDatabase;
use Carbon\Carbon;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Messerli90\IGDB\Facades\IGDB;

class ProductsImportController extends Controller
{

    private $importer;
    public function __construct(UploadToDatabase $upload)
    {
        $this->importer=$upload;
    }

    public function importForm()
    {
        return view('import.import', compact('all_products', 'uploaded_products', 'upl'));
    }


    public function import(StoreFileRequest $request)
    {
        $filename = $request->file('file');
        $games = $this->importer->getFile($filename);

        $import = Import::create();
        foreach ($games as $game) {
            $item = $import->items()->create();
            ProccessGame::dispatch($game->toArray(), $item);
        }

        return redirect()->route('products.import.log');
    }

    public function showLog()
    {
        $import = Import::orderBy('id', "desc")->first();
        $all = $import->items()->paginate(env('PAGINATE', 25));
        return view('import.log', compact('all'));
    }

    public function filter(Request $request)
    {
        $import = Import::orderBy('id', "desc")->first();
        if ($request->status == 'all') {
            $all = $import->items()->paginate(env('PAGINATE', 25));
            return view('import.log', compact('all'));
        }
        $all = $import->items()->where('status', $request->status)->paginate(env('PAGINATE',25));
        return view('import.log', compact('all'));
    }


}
