<?= view('header') ?>

<div class="container h-100">
    <div class="d-flex mb-5 flex-row-reverse">
        <a href="/logout" type="button" class="btn btn-danger">Logout</a>
    </div>
    <div class="row">
        <h2 class="py-2 text-truncate">Users.</h2>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Created at</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user):?>
                <tr>
                    <td><?= $user->username; ?></td>
                    <td><?= $user->email; ?></td>
                    <td><?= $user->created_at ?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<?= view('footer') ?>