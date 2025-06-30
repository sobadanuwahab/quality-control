<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LokasiController extends Controller
{
    public function getLokasi(Request $request)
    {
        $lat = $request->input('lat');
        $lon = $request->input('lon');

        $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $lat,
            'lon' => $lon,
        ]);

        return $response->json();
    }
}
