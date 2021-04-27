<main>  

<section>
<a href="index.php">
<button class="btn btn-success">VOLTAR</button>
</a>
</section>

<h2 class="mt-3"><?=TITLE?></h2>

<form method="post">

    <div class="form-group">
    <label>título</label>
    <input type="text" class="from-control" name="titulo" value="<?=$obVaga->titulo?>">   
    </div>

    <div class="form-group">
    <label>Descrição</label>
    <textarea class="form-control" name="descricao" rows="4"><?=$obVaga->descricao?></textarea>   
    </div>

    <div class="form-group">
      <label>Status</label>
    
        <div>
            <div class="from-check form-check-inline">
            <label class="form-control">
            <input type="radio" name="ativo" value="s" checked> ativo
            </label>
            </div>

            <div class="from-check form-check-inline">
            <label class="form-control">
            <input type="radio" name="ativo" value="n" <?=$obVaga->ativo == 'n' ? 'checked': ''?>> Inativo
            </label>
            </div>
            
        </div>

    </div>

    <div class=mt-3 class="form-group">
        <button type="submit" class="btn btn-warning">Enviar</button>
        </div>
    </form>

   </main>