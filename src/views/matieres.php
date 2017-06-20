<h2>Liste des matières</h2>

<table class="table table-bordered table striped">

    <tr>
        <th>Matières</th>
        <th>Action</th>
    </tr>

    <?php foreach($listeMatieres as $ligne):?>
        <tr>
            <td><?=$ligne["matiere"]?></td>
            <td>
                <a href="index.php?controller=matiere-delete&id=<?=$ligne["matiere_id"]?>"
                class="btn btn-danger">
                    Supprimer</a>
            </td>
        </tr>
    <?php endforeach;?>


</table>