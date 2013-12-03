<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>角色列表</h3>
                    <div class="span10 pull-right">
                    <form class="form-search">
                        <button type="submit" class="btn pull-right">搜索用户</button>
                        <input type="text" class="span5 search input-medium search-query pull-right" placeholder="搜索角色..">
                    </form>
                    </div>
                </div>
        
                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span4 sortable">
                                 <h5> 角色ID号</h5>
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span><h5>角色名称</h5>
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span><h5>创建时间</h5>
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span><h5>操作选择</h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
		    <?php
		     foreach($role_list as $role_item): ?>
                        <tr>
                            <td>
                                <? echo $role_item['role_id']; ?>
                            </td>
                            <td>
                                <? echo $role_item['role_name'];?>
                            </td>
                            <td>
                                <? echo $role_item['role_date'];?>
                            </td>
                            <td class="align-right">
                                <a href="#">查看</a>|<a href="#">修改</a>|<a href="<?=base_url().'index.php/Admin/user_index/role_del/'?><? echo $role_item['id'] ?>">删除</a>
                            </td>
                        </tr>
		     <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- end users table -->
		
		<?=$page_list;?>
            </div>
        </div>
</body>
</html>
