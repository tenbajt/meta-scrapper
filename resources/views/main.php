<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meta scrapper</title>

        <!-- Font: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">

        <!-- Resources -->
        <?= vite('resources/js/app.js') ?>
    </head>
    <body class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto space-y-6">
            <form action="/download" method="POST">
                <input type="hidden" name="nonce" value="<?= $session->nonce() ?>"/>
                <label class="form-label">URL</label>
                <div class="grid grid-cols-[1fr,auto] gap-x-2">
                    <input class="form-input" name="url" type="url" placeholder="www.example.com" value="<?= $session->flash('url') ?>" required/>
                    <button class="btn min-w-[200px]" type="submit">Pobierz</button>
                    <?php if ($session->has('error_url')): ?>
                        <span class="mt-1 text-xs text-red-500">
                            <?= $session->flash('error_url') ?>
                        </span>
                    <?php endif ?>
                </div>
            </form>
            <div class="grid grid-cols-[1fr,auto] items-center">
                <div class="form-label">Tytuł strony - meta title</div>
                <div class="text-xs">
                    <span class="<?= $session->flash('title_count_error', false) ? 'text-red-500' : '' ?>"><?= $session->flash('title_count', 0) ?></span>/75 znaków | 0/600 pikseli
                </div>
                <textarea class="form-input col-span-2 resize-none" rows="3" placeholder="Napisz tytuł opisujący treść i zachęcający do kliknięcia"><?= $session->flash('title') ?></textarea>
            </div>
            <div class="grid grid-cols-[1fr,auto] items-center">
                <div class="form-label">Opis strony - meta description</div>
                <div class="text-xs">
                    <span class="<?= $session->flash('desc_count_error', false) ? 'text-red-500' : '' ?>"><?=$session->flash('desc_count', 0)?></span>/160 znaków | 0/1000 pikseli
                </div>
                <textarea class="form-input col-span-2 resize-none" rows="6" placeholder="Użyj opisu meta, aby opisać zawartość Twojej strony. Przygotowana treść może być wyświetlana przez Google w wynikach wyszukiwania, jeśli zostanie uznana za dokładniejszą niż treść strony. Pamiętaj, że dobre opisy mogą poprawić klikalność - wpłynąć na ilość odwiedzin."><?= $session->flash('desc') ?></textarea>
            </div>
            <a class="btn w-auto" href="/clear">Wyczyść</a>
            <?php if (!empty($logger->entries())): ?>
                <table class="w-full text-sm shadow rounded-md overflow-hidden">
                    <tbody class="divide-y-2 divide-gray-50">
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-left text-gray-900 font-medium">Czas</th>
                            <th class="py-3 px-4 text-left text-gray-900 font-medium">Data</th>
                            <th class="py-3 px-4 text-left text-gray-900 font-medium">URL</th>
                        </tr>
                        <?php foreach ($logger->entries() as $entry): ?>
                            <?php $entry = explode(' ', $entry) ?>
                                <td class="py-3 px-4 text-gray-700"><?= $entry[0] ?></td>
                                <td class="py-3 px-4 text-gray-700"><?= $entry[1] ?></td>
                                <td class="py-3 px-4 text-gray-700">
                                    <a class="hover:text-blue-600 hover:underline transition-colors" href="<?= $entry[2] ?>" target="_blank"><?= $entry[2] ?></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </body>
</html>