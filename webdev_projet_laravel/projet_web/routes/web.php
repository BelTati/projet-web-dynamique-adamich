
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
Route::get('/', function () {
    return view('home');
  
});
*/

Route::get('/', [CategorieController::class, 'index'])->name('home');

//Route::get('service/{id}', [CategorieController::class, 'serviceDescription'])->name('service');
//Route::get('prestataires', [PrestataireController::class, 'recherchePrestataires'])->name('prestataires');
Route::get('/prestataire', [PrestataireController::class, 'searchProvider'])
    ->name('provider.search');

    Route::get('/categorie/{id}', [CategorieController::class, 'show'])->name('categories.show');

Route::get('/nos-prestataires', [PrestataireController::class, 'listProviders'])->name('provider.index');
// Afficher le formulaire (GET)
// Affichage du profil détaillé (Fiche)
Route::get('/prestataire/{prestataire}', [PrestataireController::class, 'showProviderProfile'])->name('provider.show');

// Lien vers le formulaire de contact (Déjà configuré précédemment)
Route::get('/contact-prestataire/{prestataire}', [PrestataireController::class, 'providerContact'])->name('provider.contact');


// Traiter l'envoi (POST) - Déjà créé précédemment
Route::post('/contact-prestataire/{prestataire}', [PrestataireController::class, 'send'])->name('contact.send');



// Public

Route::get('login', function() { return view('auth.login'); })->name('login');
Route::post('login', [AuthController::class, 'login']);


// Inscription & Confirmation
/*
Route::get('/register', [RegisterController::class, 'register'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
*/
Route::get('/register', function () {
    return view('auth.register');
})->name('register.show');

Route::post('/register', [RegisterController::class, 'register'])->name('register');


Route::get('/confirm/{token}', [RegisterController::class, 'showConfirmationForm'])->name('confirm.register');
Route::post('/confirm/{token}', [RegisterController::class, 'finalizeRegistration'])->name('confirm.finalize');


/* --- ESPACES PROTÉGÉS (Utilisateurs connectés) --- */
Route::middleware(['auth'])->group(function () {

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
 
    /* --- 1. ESPACE PRESTATAIRE (Prioritaire) --- */
    Route::middleware(['is_provider'])->prefix('provider')->name('provider.')->group(function () {
        
        // Dashboard : Nom de route = provider.dashboard
       
    Route::get('dashboard', [PrestataireController::class, 'index'])->name('dashboard');
        // Fiche Signalétique : Nom de route = provider.profile.edit
        Route::get('/fiche-signaletique', [PrestataireController::class, 'edit'])->name('fiche.edit');
        Route::post('/fiche-signaletique', [PrestataireController::class, 'update'])->name('fiche.update');
       
        Route::resource('categories', CategorieController::class)->except(['show']);
        Route::get('/categories', [CategorieController::class, 'providerIndex'])->name('categories.index');
    });

    /* --- 2. ESPACE ADMIN --- */
    Route::middleware(['is_admin'])->prefix('admin')->name('admin.')->group(function () {
     // Route dédiée pour la validation (Utilise PATCH car c'est une modification partielle)
    Route::patch('/categories/{categorie}/validate', [AdminController::class, 'validateCategory'])
         ->name('categories.validate');  
    
         Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        // Gestion des Catégories de services
        //Route::resource('categories', CategorieController::class);
        
        //Route::get('/nos-prestataires', [PrestataireController::class, 'listProviders'])->name('provider.index');
        Route::get('/gestion-prestataires', [AdminController::class, 'listPrestataires'])->name('admin.prestataires.index');
        Route::patch('/prestataire/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.prestataires.toggle-ban');

        Route::resource('categories', CategorieController::class)->except(['show']);
        
        Route::get('/categories', [CategorieController::class, 'adminIndex'])->name('categories.index');
    
        });
   // Route::get('/admin/categories', [CategorieController::class, 'adminIndex'])->name('admin.categories.index');

    /* --- 3. PROFIL STANDARD (Clients / Internautes) --- */
    // Placé en dernier pour ne pas intercepter les requêtes prestataires
    Route::get('/mon-profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mon-profil', [ProfileController::class, 'update'])->name('profile.update');

});











