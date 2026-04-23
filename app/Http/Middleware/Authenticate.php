use Illuminate\Support\Facades\Auth;

protected function redirectTo($request)
{
    if (!Auth::check()) {
        return route('login');
    }
}