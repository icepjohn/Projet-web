<h1>Liste des matières</h1>  
<div>
    <a href="index.php?controller=matieres-formulaire"
    class="btn btn-primary 	glyphicon glyphicon-folder-open"> Nouvelle matière</a>

</div><br>

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
                class="btn btn-danger glyphicon glyphicon-trash">
                    Supprimer
                </a>
                <a href="index.php?controller=matieres-formulaire&id=<?=$ligne["matiere_id"]?>"
                class="btn btn-primary glyphicon glyphicon-share">
                    modifier
                </a>

            </td>
        </tr>
    <?php endforeach;?>


</table>