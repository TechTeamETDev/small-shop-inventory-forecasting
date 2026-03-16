public function index() 
{
    if (!auth()->user()->can('view inventory')) {
        abort(403, 'Access Denied. Please contact your supervisor, Ousman Ali.');
    }
    
    return view('dashboard');
}