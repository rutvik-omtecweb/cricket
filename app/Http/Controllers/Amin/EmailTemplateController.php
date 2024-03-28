<?php

namespace App\Http\Controllers\Amin;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $email_templates = EmailTemplate::active()->get();
        return view('admin.email_template.index', compact('email_templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'title' => 'unique:email_templates,title,' . $id,
                'subject' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'This field is required.',
                'subject.required' => 'This field is required.',
                'content.required' => 'This field is required.',
            ],
        );

        $emailTemplate = $request->all();
        EmailTemplate::find($id)->update($emailTemplate);

        return redirect()->route('admin.email-template.index')->with('message', 'Email template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEmailTemplate(Request $request, $id)
    {
        $email_templates = EmailTemplate::findOrFail($id);
        return response()->json([
            "status" => true,
            "data" => $email_templates,
        ], 200);
    }
}
