<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocsAccessController extends Controller
{
    public function showLoginForm(Request $request): View
    {
        return view('docs-login', [
            'nextUrl' => $request->query('next', url('/api/docs')),
        ]);
    }

    public function storeAccessToken(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'access_token' => ['required', 'string'],
            'next' => ['nullable', 'string'],
        ]);

        $expectedToken = (string) config('app.swagger_docs_token');

        if ($expectedToken === '' || !hash_equals($expectedToken, trim($data['access_token']))) {
            return back()
                ->withErrors([
                    'access_token' => 'Токен нодуруст аст.',
                ])
                ->withInput();
        }

        $request->session()->put('swagger_docs_access_granted', true);

        return redirect()->to($data['next'] ?: url('/api/docs'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'swagger_docs_access_granted',
        ]);

        return redirect()->route('docs.login');
    }
}
