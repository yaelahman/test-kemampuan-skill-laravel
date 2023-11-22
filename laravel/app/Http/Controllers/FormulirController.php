<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\FormulirApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormulirController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $formulir = Formulir::orderBy('id', 'desc')->with('User');

        if (!$auth->isAdmin()) {
            $formulir->where('created_by', $auth->id);
        }

        $formulir = $formulir->get();

        $data = [
            'formulir' => $formulir
        ];
        return view('formulir.index', $data);
    }

    public function create()
    {
        return view('formulir.form');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $auth = Auth::user();
            $formulir = Formulir::find($request->id);

            $message = "update";

            if (!$formulir) {
                $message = "tambah";
                $formulir = new Formulir();
            }

            $formulir->sekolah = $request->sekolah;
            $formulir->harga = $request->harga;
            $formulir->created_by = $auth->id;
            $formulir->status = 0;

            $formulir->save();

            DB::commit();

            return redirect()->to(route('formulir.index'))->with('success', "Berhasil $message formulir!");
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->back()->with('error', "Gagal $message formulir!");
    }

    public function detail($id = null)
    {
        $formulir = Formulir::findOrFail($id);

        return view('formulir.detail', [
            'formulir' => $formulir,
            'auth' => Auth::user()
        ]);
    }

    public function edit($id = null)
    {
        $formulir = Formulir::findOrFail($id);

        return view('formulir.form', [
            'formulir' => $formulir,
        ]);
    }

    public function approval(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $formulir = Formulir::findOrFail($id);
            $formulir->status = $request->status;
            $formulir->save();

            $approval = new FormulirApproval();
            $approval->formulir_id = $formulir->id;
            $approval->alasan = $request->alasan;
            $approval->status = $request->status;
            $approval->approved_by = Auth::user()->id;
            $approval->save();
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil melakukan approval!');
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return redirect()->back()->with('error', "Gagal melakukan approval!");
    }

    public function delete($id = null)
    {
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus formulir!');
    }
}
