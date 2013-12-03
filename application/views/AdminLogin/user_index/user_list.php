<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>用户列表</h3>
                    <div class="span10 pull-right">
		    <form class="form-search">
			<button type="submit" class="btn pull-right">搜索用户</button>
                        <input type="text" class="span5 search input-medium search-query pull-right" placeholder="搜索用户..">
		    </form>
                    </div>
                </div>
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span4 sortable">
                                 <h5> 帐号名称</h5>
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span><h5>用户名称</h5>
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span><h5>邮件地址</h5>
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span><h5>联系电话</h5>
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span><h5>个人权限</h5>
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span><h5>操作选择</h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
		    <?php
		     foreach($user_list as $user_item): ?>
                        <tr>
                            <td>
                                <? echo $user_item['useranme']; ?>
                            </td>
                            <td>
                                <? echo $user_item['name'];?>
                            </td>
                            <td>
                                <? echo $user_item['email'];?>
                            </td>
                            <td class="align-right">
                                <? echo $user_item['mobile_phone']; ?>
                            </td>
                            <td class="align-right">
                                <? echo $user_item['purview']; ?>
                            </td>
                            <td class="align-right">
                                <a href="#">查看</a>|<a href="#">修改</a>|<a href="<?=site_url().'/Admin/user_index/user_del/'?><? echo $user_item['id'] ?>">删除</a>
                            </td>
                        </tr>
		     <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
	<?=$page_list;?>
            </div>
    </div>
</body>
</html>
