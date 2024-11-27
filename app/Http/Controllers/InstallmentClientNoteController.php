<?php

namespace App\Http\Controllers;

use App\Models\InstallmentClientNote;
use App\Http\Requests\StoreInstallmentClientNoteRequest;
use App\Http\Requests\UpdateInstallmentClientNoteRequest;
use App\Interfaces\InstallmentClientNoteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstallmentClientNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $InstallmentClientNoteRepository;

     public function __construct(InstallmentClientNoteRepositoryInterface $InstallmentClientNoteRepository)
     {
         $this->InstallmentClientNoteRepository = $InstallmentClientNoteRepository;
     }
    public function index($id)
    {
        //
        $notes = InstallmentClientNote::where('installment_client_id', $id)->get();

    // Return the notes as a JSON response
    return response()->json($notes);
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function getall($id)
    {
        $installmentClientNotes = $this->InstallmentClientNoteRepository->index($id);

        // Return data using compact
        return compact('installmentClientNotes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create()
    {
        return view('InstallmentClientNotes.create');
    }

    public function store(Request $request)
    {
        $messages = [

        ];

        $validatedData = Validator::make($request->all(), [

        ], $messages);

        if ($validatedData->fails()) {

            return $this->respondError('Validation Error.', $validatedData->errors(), 400);
        }
        $data = $this->InstallmentClientNoteRepository->store($request);
        // return response()->json($nationalities);
        // return response()->json(['message' => 'Note added successfully', 'note' => $data], 201);

        return redirect()->back()->with('success', 'InstallmentClientNote created successfully.');
        // return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstallmentClientNote  $InstallmentClientNote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $InstallmentClientNote = $this->InstallmentClientNoteRepository->show($id);
        // return response()->json($data);
        return view('InstallmentClientNotes.show', compact('InstallmentClientNote'));
        // return $this->respondSuccess($data, 'Get Data successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstallmentClientNote  $InstallmentClientNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $InstallmentClientNote = $this->InstallmentClientNoteRepository->show($id);
        // return response()->json($data);
        return view('InstallmentClientNotes.edit', compact('InstallmentClientNote'));
        // return $this->respondSuccess($data, message: 'Get Data successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstallmentClientNoteRequest  $request
     * @param  \App\Models\InstallmentClientNote  $InstallmentClientNote
     * @return \Illuminate\Http\Response
     */
    public function update($id ,  Request $request)
    {
        //
        $data = $this->InstallmentClientNoteRepository->update($id  ,$request);
        // return response()->json($data);
        return redirect()->route('InstallmentClientNotes.index')->with('success', 'InstallmentClientNote updated successfully.');
        // return $this->respondSuccess($data, 'Update Data successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstallmentClientNote  $InstallmentClientNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = $this->InstallmentClientNoteRepository->destroy($id);
        // return response()->json($data);
        // return $this->respondSuccess($data, message: 'Delete Data successfully.');
        return redirect()->route('InstallmentClientNotes.index')->with('success', 'InstallmentClientNote deleted successfully.');
    }
}
