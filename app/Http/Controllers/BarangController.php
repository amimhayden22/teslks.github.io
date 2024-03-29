<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Stock;
use Redirect;
use Form;

class BarangController extends Controller
{
    public function TampilBarang()
    {
        $barang = Barang::select('*')->get();
        $stock = Stock::all();

        return view('table_barang', compact('barang', 'stock'));
    }

    public function InputBarang(Request $request)
    {
        $cek = Barang::wherenm_brg($request->get('nm_brg'))->count();
        if ($cek > 0) {
            $jml = Barang::wherenm_brg($request->get('nm_brg'))->first()->jml_in;
            $brg = Barang::wherenm_brg($request->get('nm_brg'))->first();
            $brg->jml_in= $jml + $request->get('jml_in'); 
            $brg->save();
            
            return redirect()->back()->with('alert','jumlah');
        } else {
            $input = new Barang();
            $input->nm_brg = $request->get('nm_brg');
            $input->jml_in = $request->get('jml_in');
            $input->satuan = $request->get('satuan');
            $input->harga_brg = $request->get('harga_brg');
            $input->ket = $request->get('ket');
            $input->save();

            return redirect()->back()->with('alert','tambah');
        }
    }
    public function UpdateBarang(Request $request)
    {
        $brg = Barang::whereid($request->get('id'))->first();
        $brg->nm_brg = $request->get('nm_brg');
        $brg->jml_in = $request->get('jml_in');
        $brg->satuan = $request->get('satuan');
        $brg->harga_brg = $request->get('harga_brg');
        $brg->ket = $request->get('ket');
        $brg->save();

        return redirect()->back()->with('alert','update');
    }

    public function HapusBarang(Request $request)
    {
        $hapus = Barang::whereid($request->get('id'))->delete();
        
        return redirect()->back()->with('alert','hapus');
    }
    

}
