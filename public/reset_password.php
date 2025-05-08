<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Mot de passe oublié</title>
</head>

<body>
    <div class="bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">


                <div class="p-8 rounded-md bg-white shadow-xl">
                    <a href="reset_password.php"><img src="./images/dessin.svg" class=" mx-auto block "
                            style="width:40%" />
                    </a>
                    <h2 class="text-green-500 text-center text-xl font-semibold mb-6">Réinitialisation de mot de passe
                    </h2>
                    <div class="mb-6">
                        <p class="text-center text-sm text-gray-600">Vous avez oublié votre mot de passe ? Pas de souci
                            !
                            Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de
                            passe.</p>

                    </div>
                    <form class="mt-12 space-y-6">
                        <div>
                            <label class="text-slate-800 text-sm font-medium mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input name="email" type="text" required
                                    class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                    placeholder="login@gmail.com" />

                            </div>
                        </div>

                        <div class="hidden">
                            <label class="text-slate-800 text-sm font-medium mb-2 block ">Nouveau mot de passe</label>
                            <div class="relative flex items-center">
                                <input name="newPassword" type="password" required
                                    class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                    placeholder="Entrer votre nouveau mot de passe" />

                            </div>
                        </div>
                        <div class="hidden">
                            <label class="text-slate-800 text-sm font-medium mb-2 block">Confirmer votre mot de
                                passe</label>
                            <div class="relative flex items-center">
                                <input name="confirmPassword" type="password" required
                                    class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                    placeholder="Confirmer votre mot de passe" />

                            </div>
                        </div>


                        <div class="!mt-12">
                            <button type="button"
                                class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none cursor-pointer">
                                Réinitiliser mon mot de passe
                            </button>
                        </div>
                        <div class="text-center mt-4">

                            <a href="page_connexion.php" class="text-green-500 underline hover:underline font-medium">
                                Retour à la connexion

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>