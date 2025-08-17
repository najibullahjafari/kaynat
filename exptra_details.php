public function blog_single_id(Request $req,$id)
    {
        if($req->search_text)
        {
            $search = $req->search_text;
            $id = '';

            $arr = blog::where('title','like','%'.$search.'%')->paginate(1);
            $arr2 = blog_comment::where('user_id',$id)->get();

            $prev = '';
            $next = '';

            return view('blog-single',['arr'=>$arr,'arr2'=>$arr2,'prev'=>$prev,'next'=>$next]);
        }
        else
        {
            if($req->submit_comment)
            {
                $name = $req->name;
                $email = $req->email;
                $subject = $req->subject;
                $message = $req->message;
                $user_id = $id;

                $sql_insert = array('user_id'=>$user_id,'name'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message);
                blog_comment::create($sql_insert);
            }

            $arr = blog::where('id',$id)->get();
            $arr2 = blog_comment::where('user_id',$id)->get();

            $prev = blog::where('id','<',$id)->orderBy('id','desc')->first();
            $next = blog::where('id','>',$id)->orderBy('id','asc')->first();

            return view('blog-single',['arr'=>$arr,'arr2'=>$arr2,'prev'=>$prev,'next'=>$next]);
        }
            
    }


<div>
                                            @if($prev != null)
                                            <div class="prev-btn col-md-6 col-sm-6 col-xs-6">
                                                <a href="/blog-single/{{$prev->id}}"><i class="fa fa-angle-left"></i>Previous</a>
                                            </div>
                                            @else
                                            <div class="prev-btn col-md-6 col-sm-6 col-xs-6" style="margin-bottom:100px;"></div>
                                            @endif
                                        </div>
                                        <div>
                                            @if($next != null)
                                            <div class="next-btn col-md-6 col-sm-6 col-xs-6">
                                                <a href="/blog-single/{{$next->id}}">Next<i class="fa fa-angle-right"></i></a>
                                            </div>
                                            @else
                                            <div class="next-btn col-md-6 col-sm-6 col-xs-6" style="margin-right: 100px;"></div>
                                            @endif
                                        </div>