<?php
require "config/config.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Home</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
            <table class="table" style="margin-top: 20px; table-layout: fixed;">
                <thead>
                  <tr align="center">
                    <th scope="col">Molécule / Produit</th>
                    <th scope="col">Infos</th>
                    <th scope="col">Effets</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" class="table-danger"><center>Anti-inflammatoires</center></td>
                    </tr>
                    <tr>
                        <td>Ibuprofène / Advil</td>
                        <td>
                            <ul>
                                <li>Anti-inflammatoire</li>
                                <li>Comprimés à avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Effet peu puissant et très lent (~10min) qui dure 3h</li>
                                <li>A utiliser pour les inflammations</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="table-success"><center>Antalgiques</center></td>
                    </tr>
                    <tr>
                        <td>Doliprane/Dafalgan</td>
                        <td>
                            <ul>
                                <li>Antalgique de niveau 1</li>
                                <li>Comprimés avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Effet peu puissant et lent (~20min) qui dure ~3 heures.</li>
                                <li>Utiliser pour les douleurs légères.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Dafalgan Codéïné</td>
                        <td>
                            <ul>
                                <li>Antalgique de niveau 2</li>
                                <li>Comprimés avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Effet puissant mais lent (~10min) qui peut durer de 4 à 6 heures selon la dose.</li>
                                <li>Utiliser pour les douleurs moyennes.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Polery</td>
                        <td>
                            <ul>
                                <li>Antalgique de niveau 2</li>
                                <li>Administration par voie veineuse</li>
                                <li>Ne peut pas être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Effet très puissant et rapide (~1min) qui peut durer de 15 à 90 minutes selon la dose.</li>
                                <li>Utiliser pour les fortes douleurs.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Morphine</td>
                        <td>
                            <ul>
                                <li>Antalgique de niveau 3</li>
                                <li>Administration par voie veineuse</li>
                                <li>Ne peut pas être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Effet très puissant et rapide (~1min) qui peut durer de 15 à 90 minutes selon la dose.</li>
                                <li>Utiliser pour les fortes douleurs.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="table-primary"><center>Antibiotiques</center></td>
                    </tr>
                    <tr>
                        <td>Augmentin</td>
                        <td>
                            <ul>
                                <li>Comprimés à avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>À utiliser pour les infections légères (abcès dentaire, infection intestinale...).</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Ciflox</td>
                        <td>
                            <ul>
                                <li>Comprimés à avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>À utiliser pour les infections bactériennes (urinaire, rénale, organes...).</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Zinnat</td>
                        <td>
                            <ul>
                                <li>Comprimés à avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>À utiliser pour les infections bactériennes pulmonaires (pharyngite, laryngite...).</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Pysotacine</td>
                        <td>
                            <ul>
                                <li>Comprimés à avaler</li>
                                <li>Peut être prescrit</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>À utiliser pour les infections bactériennes de la peau (morsure de bêtes, plaie infectée...) ou intestinales.</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>         
        </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>