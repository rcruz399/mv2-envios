<?php
    use App\DevUsers;
    use App\Moviles;
    use App\Oficinas;
    $oficinas = Oficinas::all();
    
?>



<div class="menu-stock">
    <h3 class="guias__heading">Lineas - Sucursales</h3>

    <article class="consultas">

        <div class="input-buscador">
            <div class="label-buscador">
                <label for="">Buscador: </label>
            </div>

            <div>
                <input class="input-busc" id="searchTerm" onkeyup="doSearch()" type="text" name="buscador">
            </div>
        </div>

        <div class="input-buscador">
            <div class="label-buscador">
                <label for="aoficina">Oficina:</label>
            </div>
            <div>
                <select id="officinas" name="aoffice" class="input-busc s-width" onchange="busquedaPorOfficina()">
                    <option value="" disabled selected hidden>-- Seleccione una oficina --</option>
                    <?php
                        foreach ($oficinas as $oficina){
                            echo '<option value="'. $oficina->id .'">' . $oficina->nombre .  '</option>';
                        }
                    ?>

                </select>
            </div>
        </div>
    </article>


    <div class="listado">
        <div class="listado__guias">

            <table class="listado__tabla" border="2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TAG</th>
                        <th>MODELO</th>
                        <th>LINEA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>CELNOG106</td>
                        <td>HUAWEI AMN-LX3</td>
                        <td>6441500242</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>CELNOG106</td>
                        <td>HUAWEI AMN-LX3</td>
                        <td>6441500242</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="lineas">
        <p class="lineas__stock">Lineas en uso: <span class="lineas__stock--span lineas__stock--blue">75</span></p>
        <p class="lineas__stock">Lineas sin uso: <span class="lineas__stock--span">35</span></p>
        <p class="lineas__stock">Total: <span class="lineas__stock--span lineas__stock--black">110</span></p>
    </div>

</div>