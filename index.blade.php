@extends('layouts.app')

@section('content')
<main>
<div class="container">
    <div class="col-md-12">
        
        <div class="col-md-12">
        {!! Form::open(['route' => 'komentar.store']) !!}
        <div class="row">
        <textarea class="col-md-12" name="komentar" placeholder="Ostavite svoj komentar" style="border-radius: 10px; resize: none; min-height: 200px;"></textarea>
        </div>
        <div class="row">
        <!--<input type="text" name="name">-->
        </div>
        <input type="submit" name="potvrda" value="Upisi" class="btn btn-warning col-md-12" style="margin-top: 20px; background-color: black;">
        {!! Form::close() !!}
        <div class="col-md-12" style="margin-top: 20px;">
        
        @php
        function PrikazKomentara($comments, $i, $j)
        {
               $j++;
               $a=12-$j;
               for($k=0; $k<=$i;$k++)
               {
               //echo "na dubini ".$j." se nalazi ".$comments[$i]->comment;
               echo "<div class=\"col-md-".$a." col-md-offset-".$j."\" style=\"background-color: #edf3f4; margin-bottom: 10px; border-radius: 10px; min-height: 100px;\">
            <div class=\"col-md-10\">
                <h5>Komentar korisnika: ";
                $user=$comments[$k]->BelongsToUser()->get();
                if($user->isEmpty())
                {}
                else
                {
                   echo $user[0]->name ;
                }
                echo "</h5>";
            echo $comments[$k]->comment;
            echo "
            </div>
            <div class=\"col-md-2\">";
            echo $comments[$k]->created_at;
            echo "<div class=\"dropdown\">
            <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Prokomentariši
            <span class=\"caret\"></span></button>
            <ul class=\"dropdown-menu\">";
                     @endphp
                {!! Form::open(['route' => 'komentar.store']) !!}
            <input type="hidden" name="idComment" value="{{ $comments[$k]->id }}">
            <textarea name="odgovor"></textarea>
            <button type="submit" class="btn btn-primary">Odgovori</button>
            {!! Form::close() !!}
            @php
            echo "</ul>
          </div>
            </div>
        </div>";
               $comm2=$comments[$k]->HasComments()->get();
               if($comm2->isEmpty())
                {

                }
                else
                {
                    PrikazKomentara($comm2, count($comm2)-1, $j);
                }
            }
        }
        $brKom=1;
        $brBloka=0;
        $BlokBrojB=false;
        foreach ($comments as $comment) {
            
           $comm=$comment->BelongsToComment()->get();
           if($comm->isEmpty())
           {
                if($brKom % 16==0)
                {
                    $brBloka++;
                    echo "<div id='BlokKom".$brBloka."' style='display:none;'>";
                    $BlokBrojB=true;
                    
                }
                $brKom++;



            echo "<div class=\"col-md-12\" style=\"background-color: #edf3f4; margin-bottom: 10px; border-radius: 10px; min-height: 100px;\">
            <div class=\"col-md-10\">
                <h5>Komentar korisnika: ";
                $user=$comment->BelongsToUser()->get();
                if($user->isEmpty())
                {}
                else
                {
                   echo $user[0]->name ;
                }
                echo "</h5>";
            echo $comment->comment;
            echo "
            </div>
            <div class=\"col-md-2\">";
            echo $comment->created_at;
            echo "<br>";
            $likes=$comment->BelongsToUserLike()->get();
            if ($likes->isEmpty()) {
                echo "<img style='cursor: pointer; float:left; padding-right:10px; margin-bottom:20px;' src=\"/theme/images/like.png\" id='likesImg".$comment->id."' onclick=\"addLike($comment->id, $comment->likes);\">";
            }
            else
            {
                echo "<img style='cursor: pointer; float:left; padding-right:10px; margin-bottom:20px;' src=\"/theme/images/like_blue.png\" id='likesImg".$comment->id."' onclick=\"deleteLike($comment->id, $comment->likes);\">";
            }
            echo "<div style='float:left; padding-right:20px;' id='likes".$comment->id."'>".$comment->likes."</div>";

            $dislikes=$comment->BelongsToUserDisLike()->get();
            if ($dislikes->isEmpty()) {
               echo "<img style='cursor: pointer; float:left; padding-right:10px;' src=\"/theme/images/dislike.png\" id='disLikesImg".$comment->id."' onclick=\"addDisLike($comment->id, $comment->dislikes);\">";
            }
            else
            {
                echo "<img style='cursor: pointer; float:left; padding-right:10px;' src=\"/theme/images/dislike_blue.png\" id='disLikesImg".$comment->id."' onclick=\"deleteDisLike($comment->id, $comment->dislikes);\">";
            }
            
            echo "<div style='float:left; padding-right:20px;' id='disLikes".$comment->id."'>".$comment->dislikes."</div>";
            echo "<br><br>";
           echo " <div class=\"dropdown\">
            <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Prokomentariši
            <span class=\"caret\"></span></button>
            <ul class=\"dropdown-menu\">
              ";
            
            @endphp
                {!! Form::open(['route' => 'komentar.store']) !!}
            <input type="hidden" name="idComment" value="{{ $comment->id }}">
            <textarea name="odgovor"></textarea>
            <button type="submit" class="btn btn-primary">Odgovori</button>
            {!! Form::close() !!}
            @php
            $comm2=$comment->HasComments()->get();
            echo "</ul>
          </div>
            </div>";
            if (!$comm2->isEmpty()) {
               echo "<img style='cursor: pointer;' src='/theme/images/arrow2.png' onclick='showChild(".$comment->id.", this);'/>"; 
            }  
        echo "</div>";
            //$comm2=$comment->HasComments()->get();
            if($comm2->isEmpty())
            {
                
            }
            else
            {
                echo "<div id='ChildComments".$comment->id."' style='display: none;'>";
                PrikazKomentara($comm2, count($comm2)-1, 0);
                echo "</div>";
            }


            if($brKom%16==0)
            {
                if ($BlokBrojB) {
                    echo "</div>";
                }
                
            }
            
           }
           else
           {
            
           }

        }
        if($brKom%16!=0)
            {
                if ($BlokBrojB) {
                    echo "</div>";
                }
            }
            if ($brKom>16) {
                echo "<div class='col-md-6 col-md-offset-3'>";
                echo "<img style='cursor: pointer;' src='/theme/images/prikazijos1.png' onclick='prikaziJos(1, this)'/>";
                echo "</div>";
            }
         //$com2=$comments[20]->HasComments()->get();
         //print_r($com2->HasComments()->get());
             //  print_r($com2);
        @endphp
       {{--  @foreach($comments as $comment)
        <div class="col-md-12" style="background-color: #edf3f4; margin-bottom: 10px; border-radius: 10px; min-height: 100px;">
            <div class="col-md-10">
                <h4>{{ $comment->comment }}</h4>
            </div>
            <div class="col-md-2">
            {{ $comment->created_at }}
            {!! Form::open(['route' => 'komentar.store']) !!}
            <input type="hidden" name="idComment" value="{{ $comment->id }}">
            <textarea name="odgovor"></textarea>
            <button type="submit">Odgovori</button>
            {!! Form::close() !!}
            </div>
        </div>
        @endforeach --}}
        

        </div>
        
    </div>
</div>
<script type="text/javascript">
    function addLike(id, likes)
    {
        //alert('AAA');
        var token, url, data;
        token = $('input[name=_token]').val();
        var idCom="likes"+id.toString();
        var idComImg="#likesImg"+id.toString();
        //var funAddLike="addLike("+id.toString()+", "+likes.toString()+");";
        url = 'komentar/addLike';
        data = {id: id, likes: likes};
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: data,
            type: 'POST',
            datatype: 'JSON',
            success: function (resp) {
                //alert(resp.likes);
                 document.getElementById(idCom).innerHTML = resp.likes;
                  //$(idComImg).attr("onclick", "addLike("+id.toString()+", "+resp.likes.toString()+");");
                  $(idComImg).attr("src", "/theme/images/like_blue.png");
                  $(idComImg).attr("style", " cursor:pointer; float:left; padding-right:10px; margin-bottom:20px;");
                  $(idComImg).attr("onclick", "deleteLike("+id.toString()+", "+resp.likes.toString()+");");

            },
            error: function (resp) {
                alert('CCC');
            }
        });
    }
    function deleteLike(id, likes)
    {
        //alert('AAA');
        var token, url, data;
        token = $('input[name=_token]').val();
        var idCom="likes"+id.toString();
        var idComImg="#likesImg"+id.toString();
        //var funAddLike="addLike("+id.toString()+", "+likes.toString()+");";
        url = 'komentar/deleteLike';
        data = {id: id, likes: likes};
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: data,
            type: 'POST',
            datatype: 'JSON',
            success: function (resp) {
                //alert(resp.likes);
                 document.getElementById(idCom).innerHTML = resp.likes;
                  //$(idComImg).attr("onclick", "addLike("+id.toString()+", "+resp.likes.toString()+");");
                  $(idComImg).attr("src", "/theme/images/like.png");
                  $(idComImg).attr("style", "cursor:pointer; float:left; padding-right:10px; margin-bottom:20px;");
                  $(idComImg).attr("onclick", "addLike("+id.toString()+", "+resp.likes.toString()+");");

            },
            error: function (resp) {
                alert('CCC');
            }
        });
    }
    function addDisLike(id, dislikes)
    {
         var token, url, data;
        token = $('input[name=_token]').val();
        var idCom="disLikes"+id.toString();
        var idComImg="#disLikesImg"+id.toString();
        //var funAddLike="addLike("+id.toString()+", "+likes.toString()+");";
        url = 'komentar/addDisLike';
        data = {id: id, dislikes: dislikes};
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: data,
            type: 'POST',
            datatype: 'JSON',
            success: function (resp) {
                //alert(resp.dislikes);
                  document.getElementById(idCom).innerHTML = resp.dislikes;
                  //$(idComImg).attr("onclick", "addLike("+id.toString()+", "+resp.likes.toString()+");");
                  $(idComImg).attr("src", "/theme/images/dislike_blue.png");
                  $(idComImg).attr("style", "cursor:pointer; float:left; padding-right:10px; margin-bottom:20px;");
                  $(idComImg).attr("onclick", "deleteDisLike("+id.toString()+", "+resp.dislikes.toString()+");");

            },
            error: function (resp) {
                alert('CCC');
            }
        });
    }
    function deleteDisLike(id, dislikes)
    {
         var token, url, data;
        token = $('input[name=_token]').val();
        var idCom="disLikes"+id.toString();
        var idComImg="#disLikesImg"+id.toString();
        //var funAddLike="addLike("+id.toString()+", "+likes.toString()+");";
        url = 'komentar/deleteDisLike';
        data = {id: id, dislikes: dislikes};
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: data,
            type: 'POST',
            datatype: 'JSON',
            success: function (resp) {
                //alert(resp.dislikes);
                  document.getElementById(idCom).innerHTML = resp.dislikes;
                  //$(idComImg).attr("onclick", "addLike("+id.toString()+", "+resp.likes.toString()+");");
                  $(idComImg).attr("src", "/theme/images/dislike.png");
                  $(idComImg).attr("style", "cursor:pointer; float:left; padding-right:10px; margin-bottom:20px;");
                  $(idComImg).attr("onclick", "addDisLike("+id.toString()+", "+resp.dislikes.toString()+");");

            },
            error: function (resp) {
                alert('CCC');
            }
        });
    }

    function showChild(id, curId)
    {

        var idCom="#ChildComments"+id.toString();
        if ($(idCom).attr("style")=="") {
            $(idCom).attr("style", "display: none");
            $(curId).attr("style", "cursor: pointer; transform: rotate(0deg)");
        }
        else
        {
            $(idCom).attr("style", "");
            $(curId).attr("style", "cursor: pointer; transform: rotate(90deg)");

        }
    }


    function prikaziJos(brBloka, idPrikJos)
    {
        var idBlok="#BlokKom"+brBloka.toString();
        var brBloka1=brBloka+1;
        $(idBlok).attr("style", "");
        $(idPrikJos).attr("onclick", "prikaziJos("+brBloka1.toString()+", this)");
    }
</script>
<main>
@endsection
