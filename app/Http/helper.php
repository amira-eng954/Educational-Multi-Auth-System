<?php



function successResponse($message=null,$data=null)
{

    $response=[
        'status'=>true,
        'message'=>$message,
        'data'=>$data
    ];
    return response()->json($response,200);


}

function failResponse($message=null,$data=null)
{
    $response=[
        'status'=>false,
        'message'=>$message,
        'data'=>$data
    ];
    return response()->json($response,422);
}

function unauthorize($massage="un authorize")
{
    $response=[
        'status'=>false,
        'message'=>$massage
    ];
    return response()->json($response,403);
}

?>