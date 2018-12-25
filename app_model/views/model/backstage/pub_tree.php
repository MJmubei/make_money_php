
<script type="text/javascript">

    var defaultData =[
    {
        "permission_id": 1,
        "parent_permission_id": 0,
        "text": "系统管理",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-desktop",
        "level": 0,
        "nodes": [
            {
                "permission_id": 2,
                "parent_permission_id": 1,
                "text": "权限管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-sitemap",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 7,
                        "parent_permission_id": 2,
                        "text": "权限列表",
                        "permission_url": "permission/permission_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(7);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(7);\">删除</button></span>"
                    },
                    {
                        "permission_id": 12,
                        "parent_permission_id": 2,
                        "text": "获取权限数据",
                        "permission_url": "permission/get_permission_json",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(12);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(12);\">删除</button></span>"
                    },
                    {
                        "permission_id": 13,
                        "parent_permission_id": 2,
                        "text": "编辑权限",
                        "permission_url": "permission/permission_edit",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(13);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(13);\">删除</button></span>"
                    },
                    {
                        "permission_id": 14,
                        "parent_permission_id": 2,
                        "text": "删除权限",
                        "permission_url": "permission/permission_del",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(14);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(14);\">删除</button></span>"
                    },
                    {
                        "permission_id": 31,
                        "parent_permission_id": 2,
                        "text": "权限增加",
                        "permission_url": "permission/permission_add",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(31);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(31);\">删除</button></span>"
                    }
                ],
                "tags": 5,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(2);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(2);\">删除</button></span>"
            },
            {
                "permission_id": 21,
                "parent_permission_id": 1,
                "text": "系统权限分组管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-object-group",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 22,
                        "parent_permission_id": 21,
                        "text": "系统分组列表",
                        "permission_url": "group/group_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(22);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(22);\">删除</button></span>"
                    },
                    {
                        "permission_id": 25,
                        "parent_permission_id": 21,
                        "text": "系统权限分组增加",
                        "permission_url": "group/group_add",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(25);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(25);\">删除</button></span>"
                    },
                    {
                        "permission_id": 26,
                        "parent_permission_id": 21,
                        "text": "系统权限分组编辑",
                        "permission_url": "group/group_edit",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(26);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(26);\">删除</button></span>"
                    },
                    {
                        "permission_id": 27,
                        "parent_permission_id": 21,
                        "text": "分组删除",
                        "permission_url": "group/group_del",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(27);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(27);\">删除</button></span>"
                    },
                    {
                        "permission_id": 28,
                        "parent_permission_id": 21,
                        "text": "系统权限分组获取数据",
                        "permission_url": "group/get_group_json",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(28);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(28);\">删除</button></span>"
                    },
                    {
                        "permission_id": 32,
                        "parent_permission_id": 21,
                        "text": "系统权限分组权限管理",
                        "permission_url": "group/edit_permission",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(32);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(32);\">删除</button></span>"
                    },
                    {
                        "permission_id": 38,
                        "parent_permission_id": 21,
                        "text": "获取分组权限数据json",
                        "permission_url": "group/get_permission_json",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(38);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(38);\">删除</button></span>"
                    }
                ],
                "tags": 7,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(21);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(21);\">删除</button></span>"
            },
            {
                "permission_id": 29,
                "parent_permission_id": 1,
                "text": "系统用户管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-user",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 30,
                        "parent_permission_id": 29,
                        "text": "系统用户列表",
                        "permission_url": "admin/admin_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(30);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(30);\">删除</button></span>"
                    },
                    {
                        "permission_id": 33,
                        "parent_permission_id": 29,
                        "text": "系统用户增加",
                        "permission_url": "admin/admin_add",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(33);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(33);\">删除</button></span>"
                    },
                    {
                        "permission_id": 34,
                        "parent_permission_id": 29,
                        "text": "系统用编辑",
                        "permission_url": "admin/admin_edit",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(34);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(34);\">删除</button></span>"
                    },
                    {
                        "permission_id": 35,
                        "parent_permission_id": 29,
                        "text": "获取该用户的分组ID集合",
                        "permission_url": "admin/get_group_json",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(35);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(35);\">删除</button></span>"
                    },
                    {
                        "permission_id": 36,
                        "parent_permission_id": 29,
                        "text": "系统用户删除",
                        "permission_url": "admin/admin_del",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(36);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(36);\">删除</button></span>"
                    },
                    {
                        "permission_id": 37,
                        "parent_permission_id": 29,
                        "text": "系统用户所在分组编辑",
                        "permission_url": "admin/edit_group",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(37);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(37);\">删除</button></span>"
                    }
                ],
                "tags": 6,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(29);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(29);\">删除</button></span>"
            }
        ],
        "tags": 3,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(1);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(1);\">删除</button></span>"
    },
    {
        "permission_id": 4,
        "parent_permission_id": 0,
        "text": "新闻管理中心",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-newspaper-o",
        "level": 0,
        "nodes": [
            {
                "permission_id": 5,
                "parent_permission_id": 4,
                "text": "新闻管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-list-alt",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 8,
                        "parent_permission_id": 5,
                        "text": "新闻分类管理",
                        "permission_url": "news/news_category",
                        "tag": "",
                        "small_icon_name": "fa fa-book",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(8);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(8);\">删除</button></span>"
                    },
                    {
                        "permission_id": 11,
                        "parent_permission_id": 5,
                        "text": "获取新闻分类数据",
                        "permission_url": "news/get_news_category_json",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(11);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(11);\">删除</button></span>"
                    },
                    {
                        "permission_id": 39,
                        "parent_permission_id": 5,
                        "text": "新闻列表",
                        "permission_url": "news/news_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(39);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(39);\">删除</button></span>"
                    },
                    {
                        "permission_id": 40,
                        "parent_permission_id": 5,
                        "text": "增加新闻",
                        "permission_url": "news/news_add",
                        "tag": "",
                        "small_icon_name": "fa fa-home",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(40);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(40);\">删除</button></span>"
                    }
                ],
                "tags": 4,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(5);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(5);\">删除</button></span>"
            }
        ],
        "tags": 1,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(4);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(4);\">删除</button></span>"
    },
    {
        "permission_id": 48,
        "parent_permission_id": 0,
        "text": "电商管理中心",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-shopping-cart",
        "level": 0,
        "nodes": [
            {
                "permission_id": 51,
                "parent_permission_id": 48,
                "text": "反馈管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-paperclip",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 52,
                        "parent_permission_id": 51,
                        "text": "反馈列表",
                        "permission_url": "feedback/feedback_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(52);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(52);\">删除</button></span>"
                    }
                ],
                "tags": 1,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(51);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(51);\">删除</button></span>"
            },
            {
                "permission_id": 54,
                "parent_permission_id": 48,
                "text": "商品管理",
                "permission_url": "",
                "tag": "",
                "small_icon_name": "fa fa-codepen",
                "level": 1,
                "nodes": [
                    {
                        "permission_id": 55,
                        "parent_permission_id": 54,
                        "text": "商品列表",
                        "permission_url": "goods/goods_list",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(55);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(55);\">删除</button></span>"
                    },
                    {
                        "permission_id": 57,
                        "parent_permission_id": 54,
                        "text": "商品分类列表",
                        "permission_url": "goods/goods_category",
                        "tag": "",
                        "small_icon_name": "fa fa-list",
                        "level": 2,
                        "tags": 0,
                        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(57);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(57);\">删除</button></span>"
                    }
                ],
                "tags": 2,
                "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(54);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(54);\">删除</button></span>"
            }
        ],
        "tags": 2,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(48);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(48);\">删除</button></span>"
    },
    {
        "permission_id": 49,
        "parent_permission_id": 0,
        "text": "API管理中心",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-link",
        "level": 0,
        "tags": 0,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(49);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(49);\">删除</button></span>"
    },
    {
        "permission_id": 50,
        "parent_permission_id": 0,
        "text": "H5微信管理中心",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-weixin",
        "level": 0,
        "tags": 0,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(50);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(50);\">删除</button></span>"
    },
    {
        "permission_id": 53,
        "parent_permission_id": 0,
        "text": "会员管理中心",
        "permission_url": "",
        "tag": "",
        "small_icon_name": "fa fa-user-circle",
        "level": 0,
        "tags": 0,
        "after_html": "<span class=\"button_z\"><button type=\"button\" class=\"btn btn btn-info btn-xs\" onclick=\"edit(53);\">编辑</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"del(53);\">删除</button></span>"
    }
];

    var $checkableTree = $('#treeview-checkable').treeview({
      data: defaultData,
      showIcon: false,
      showCheckbox: true,
      selectedBackColor: '#ffffcc',
      selectedColor: '#000000',
      showTags: true,
      onNodeChecked: function (event, node) {
        $('#checkable-output').prepend('<p>' + node.text + ' was checked</p>');
        // console.log(event);
        // console.log(node.nodes);

        // $.each(node.nodes, function (index, value, array) {
        //   console.log(value);

        // });
        checkAllParent(node);
        // checkAllSon(node);
      },
      onNodeUnchecked: function (event, node) {
        $('#checkable-output').prepend('<p>' + node.text + ' was unchecked</p>');

        uncheckAllParent(node);
        uncheckAllSon(node);
      }

    });
    $('#treeview-checkable').on('nodeSelected', function (event, data) {
      // Your logic goes here 
      //   console.log('222222222222222222');
      console.log(data.id);
    });



    var nodeCheckedSilent = false;
    function nodeChecked(event, node) {
      if (nodeCheckedSilent) {
        return;
      }
      nodeCheckedSilent = true;
      checkAllParent(node);
      checkAllSon(node);
      nodeCheckedSilent = false;
    }

    var nodeUncheckedSilent = false;
    function nodeUnchecked(event, node) {
      if (nodeUncheckedSilent)
        return;
      nodeUncheckedSilent = true;
      uncheckAllParent(node);
      uncheckAllSon(node);
      nodeUncheckedSilent = false;
    }

    //选中全部父节点  
    function checkAllParent(node) {
      $('#treeview-checkable').treeview('checkNode', node.nodeId, { silent: true });
      var parentNode = $('#treeview-checkable').treeview('getParent', node.nodeId);
      if (!("nodeId" in parentNode)) {
        return;
      } else {
        checkAllParent(parentNode);
      }
    }
    //取消全部父节点  
    function uncheckAllParent(node) {
      $('#treeview-checkable').treeview('uncheckNode', node.nodeId, { silent: true });
      var siblings = $('#treeview-checkable').treeview('getSiblings', node.nodeId);
      var parentNode = $('#treeview-checkable').treeview('getParent', node.nodeId);
      if (!("nodeId" in parentNode)) {
        return;
      }
      var isAllUnchecked = true;  //是否全部没选中  
      for (var i in siblings) {
        if (siblings[i].state.checked) {
          isAllUnchecked = false;
          break;
        }
      }
      if (isAllUnchecked) {
        uncheckAllParent(parentNode);
      }

    }

    //级联选中所有子节点  
    function checkAllSon(node) {
      $('#treeview-checkable').treeview('checkNode', node.nodeId, { silent: true });
      if (node.nodes != null && node.nodes.length > 0) {
        for (var i in node.nodes) {
          checkAllSon(node.nodes[i]);
        }
      }
    }
    //级联取消所有子节点  
    function uncheckAllSon(node) {
      $('#treeview-checkable').treeview('uncheckNode', node.nodeId, { silent: true });
      if (node.nodes != null && node.nodes.length > 0) {
        for (var i in node.nodes) {
          uncheckAllSon(node.nodes[i]);
        }
      }
    }  
  </script>