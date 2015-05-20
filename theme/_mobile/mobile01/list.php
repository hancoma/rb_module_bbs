<?php getImport('bootstrap-select','bootstrap-select',false,'js')?>
<?php getImport('bootstrap-select','bootstrap-select',false,'css')?>
<link href="<?php echo $g['dir_module_skin']?>/_main.css" rel="stylesheet">
<section id="rb-forum" class="rb-forum-list">
    <div class="panel panel-default rb-panel-table">
      
        <!-- 총게시물, th, 검색창 출력부  -->
        <div class="panel-body">
            <div class="row rb-search">
                <div class="col-sm-4">
                    <span class="rb-search-result text-muted">
                        <small>총게시물 : <strong><?php echo number_format($NUM+count($NCD))?></strong> 건  (<?php echo $p?>/<?php echo $TPG?> page ) </small>
                    </span>
                </div>
                
                <!-- 검색창 출력부  -->
                <div class="col-sm-8">
                       <?php if($d['theme']['search']):?>
                       <form name="bbssearchf" action="<?php echo $g['s']?>/">
                        <input type="hidden" name="r" value="<?php echo $r?>" />
                        <input type="hidden" name="c" value="<?php echo $c?>" />
                        <input type="hidden" name="m" value="<?php echo $m?>" />
                        <input type="hidden" name="bid" value="<?php echo $bid?>" />
                        <input type="hidden" name="cat" value="<?php echo $cat?>" />
                        <input type="hidden" name="sort" value="<?php echo $sort?>" />
                        <input type="hidden" name="orderby" value="<?php echo $orderby?>" />
                        <input type="hidden" name="recnum" value="<?php echo $recnum?>" />
                        <input type="hidden" name="type" value="<?php echo $type?>" />
                        <input type="hidden" name="iframe" value="<?php echo $iframe?>" />
                        <input type="hidden" name="skin" value="<?php echo $skin?>" />
                        
                        <!-- 카테고리 출력부  -->
                        <?php if($B['category']):$_catexp = explode(',',$B['category']);$_catnum=count($_catexp)?>                   
                        <div class="col-sm-1" style="padding-left:0;">
                            <select name="category" class="boot-select" data-width="auto" data-header="" data-style="btn-default btn-sm" onchange="document.bbssearchf.cat.value=this.value;document.bbssearchf.submit();">
                                <option value=""><?php echo $_catexp[0]?></option>
                                <?php for($i = 1; $i < $_catnum; $i++):if(!$_catexp[$i])continue;?>
                                    <option value="<?php echo $_catexp[$i]?>"<?php if($_catexp[$i]==$cat):?> selected="selected"<?php endif?>>ㆍ<?php echo $_catexp[$i]?><?php if($d['theme']['show_catnum']):?>(<?php echo getDbRows($table[$m.'data'],'site='.$s.' and notice=0 and bbs='.$B['uid']." and category='".$_catexp[$i]."'")?>)<?php endif?></option>
                               <?php endfor?>
                            </select>
                        </div>
                        <?php else:?>
                        <div class="col-sm-1">
                        </div>
                        <?php endif?>
                        
                         <div class="input-group input-group-sm col-sm-7 pull-right">
                            <span class="input-group-btn">
                                <select name="where" class="boot-select" data-width="auto" data-style="btn-default btn-sm">
                                    <option value="subject|tag"<?php if($where=='subject|tag'):?> selected="selected"<?php endif?>>제목+태그</option>
                                    <option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
                                    <option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>이름</option>
                                    <option value="nic"<?php if($where=='nic'):?> selected="selected"<?php endif?>>닉네임</option>
                                    <option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
                                    <option value="term"<?php if($where=='term'):?> selected="selected"<?php endif?>>등록일</option>
                                </select>                         
                            </span>
                            <input type="search" class="form-control" name="keyword" value="<?php echo $_keyword?>" placeholder="검색어를 입력해주세요">
                            <span  class="input-group-btn va-top">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div> <!-- 검색 input-group -->

                </div> <!-- .col-sm-8 -->
             </form> 
             <?php endif?>
            </div><!-- .row rb-search -->
        </div> <!-- .panel-body -->
        <div class="table-responsive">
            <table class="table table-bordered" summary="번호,제목,작성일,조회수,첨부 항목을 포함한 목록">
                <colgroup>
                    <col width="10%"></col>
                    <col></col>
                    <col width="13%"></col>
                    <col width="15%"></col>
                    <col width="10%"></col>
                </colgroup>
                <thead>
                    <tr class="active">
                        <th class="text-center">번호</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">글쓴이</th>
                        <th class="text-center">작성일</th>
                        <th class="text-center">조회</th>
                    </tr>
                </thead>
                <tbody>

                 <!-- 공지사항 출력부  -->
                <?php foreach($NCD as $R):?> 
                <?php $R['mobile']=isMobileConnect($R['agent'])?>
                <tr class="active">
                    <td class="text-center">
                        <?php if($R['uid'] != $uid):?>
                           <span class="label label-info">공지</span>
                        <?php else:?>
                           <span class="now">&gt;&gt;</span>
                        <?php endif?>   
                    </td>
                    <td>
                        <?php if($R['mobile']):?><i class="fa fa-mobile fa-lg"></i><?php endif?>
                         <?php if($R['category']):?><span class="text-danger">[<?php echo $R['category']?>]</span><?php endif?>
                        <a href="<?php echo $g['bbs_view'].$R['uid']?>"><?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?></a>
                        <?php if(strstr($R['content'],'.jpg')):?><i class="fa fa-image fa-lg"></i><?php endif?>
                        <?php if($R['upload']):?><i class="glyphicon glyphicon-floppy-disk glyphicon-lg"></i><?php endif?>
                        <?php if($R['hidden']):?><i class="fa fa-lock fa-lg"></i><?php endif?>
                        <?php if($R['comment']):?><span class="badge"><?php echo $R['comment']?><?php echo $R['oneline']?'+'.$R['oneline']:''?></span><?php endif?>
                        <?php if($R['trackback']):?><span class="trackback">[<?php echo $R['trackback']?>]</span><?php endif?>
                         <?php if(getNew($R['d_regis'],24)):?><span class="label label-danger"><small>New</small></span><?php endif?>            
                    </td>
                    <td class="text-center"><?php echo $R[$_HS['nametype']]?></a></td>
                    <td class="text-center"><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></td>
                    <td class="text-center"><?php echo $R['hit']?></td>
                </tr>
               <?php endforeach?>

                <!-- 일반글 출력부 -->
                <?php foreach($RCD as $R):?> 
                <?php $R['mobile']=isMobileConnect($R['agent'])?>
                <tr>
                    <td class="text-center">
                        <?php if($R['uid'] != $uid):?>
                            <?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
                       <?php else:$_rec++?>
                           <span class="now">&gt;&gt;</span>
                        <?php endif?>   
                    </td>
                    <td>
                        <?php if($R['mobile']):?><i class="fa fa-mobile fa-lg"></i><?php endif?>
                        <?php if($R['category']):?><span class="text-danger">[<?php echo $R['category']?>]</span><?php endif?>
                        <a href="<?php echo $g['bbs_view'].$R['uid']?>"><?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?></a>
                         <?php if(strstr($R['content'],'.jpg')):?><i class="fa fa-image fa-lg"></i><?php endif?>
                        <?php if($R['upload']):?><i class="glyphicon glyphicon-floppy-disk glyphicon-lg"></i><?php endif?>
                        <?php if($R['hidden']):?><i class="fa fa-lock fa-lg"></i><?php endif?>
                        <?php if($R['comment']):?><span class="badge"><?php echo $R['comment']?><?php echo $R['oneline']?'+'.$R['oneline']:''?></span><?php endif?>
                        <?php if($R['trackback']):?><span class="trackback">[<?php echo $R['trackback']?>]</span><?php endif?>
                         <?php if(getNew($R['d_regis'],24)):?><span class="label label-danger"><small>New</small></span><?php endif?>            
                    </td>
                    <td class="text-center"><?php echo $R[$_HS['nametype']]?></a></td>
                    <td class="text-center"><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></td>
                    <td class="text-center"><?php echo $R['hit']?></td>
                </tr>
               <?php endforeach?>
              </tbody>
            </table>
        </div>    
        <div class="panel-footer bg-transparent">
            <div class="row">
                <?php if($my['admin']):?>
                    <div class="col-sm-1 pull-left">
                        <span class="pagination">
                           <a class="btn btn-danger" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=<?php echo $m?>&amp;front=skin&amp;theme=<?php echo $d['bbs']['skin']?>"><i class="fa fa-cog"></i> 관리</a></span>
                        </span>
                    </div>      
                  <?php endif?>        
                    <div class="col-sm-10 text-center">
                       <span class="pagination pagination-sm"><?php echo getPageLink($d['theme']['pagenum'],$p,$TPG,'')?></span>
                    </div>
                    <div class="col-sm-1 pull-right">
                        <span class="pull-right pagination"> 
                           <a class="btn btn-default" href="<?php echo $g['bbs_write']?>"><i class="fa fa-pencil"></i> 등록</a>
                        </span>
                    </div>
              </div>
        </div> <!-- .panel-footer --> 
    </div> <!-- .panel panel-default rb-panel-table -->
</section>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
    // bootstrap-select 활성화 
    $('.boot-select').selectpicker();
}); 

//]]>
</script>



