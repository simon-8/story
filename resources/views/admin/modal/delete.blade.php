<div class="modal inmodal" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">确认操作</h4>
                <small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>
            </div>
            <div class="modal-body">
                <p>你开心就好。</p>
            </div>
            <div class="modal-footer">
                <form action="{{ $formurl }}">
                    <input type="hidden" name="id" value="0">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </form>
            </div>
        </div>
    </div>
</div>