<div class="col-md-10 col-md-offset-1">
    <?php if(isset($this->___data['error'])): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Error!</h4>
            <p><?= $this->___data['error']; ?></p>
        </div>
    <?php endif; ?>
    <form class="form-horizontal" method="post" action=" <?= $this->getbaseUrl() . 'posts/add' ?> ">
        <fieldset>
            <legend>Articles</legend>
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                </div>
            </div>
            <div class="form-group">
                <label for="text" class="col-lg-2 control-label">Text</label>
                <div class="col-lg-10">
                    <textarea class="form-control" name="text" rows="3" id="text"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tags" class="col-lg-2 control-label">Tags</label>
                <div class="col-lg-10">
                    <input type="text" name="tags" class="form-control" id="tags" placeholder="Tags">
                    <span class="help-block">Please enter tags separated with comma and space.</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button name="submit" value="1" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>