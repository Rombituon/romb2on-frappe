<?php

// it('can connect to frappe site', function () {
//     $frappe = new Romb2on\Frappe\Frappe();
//     $res=$frappe->authenticate();
//     expect($res->message=="Logged In")->toBeTrue();
// });

// it('can get user details', function () {
//     $frappe = new Romb2on\Frappe\Frappe();
//     $res=$frappe->getUser('jurin@example.com');
//     dd($res);
//     expect($res->data->name != null)->toBeTrue();
// });



// it('can update user detail', function () {
//     $frappe = new Romb2on\Frappe\Frappe();
//     $res=$frappe->doctype()->update('User','jurin@example.com',[
//         'first_name'=>'Jurin'
//     ]);
//     dd($res);
//     // expect($res->data->name != null)->toBeTrue();
// });


it('can get all data', function () {
    $frappe = new Romb2on\Frappe\Frappe();
    $res=$frappe->doctype()->getAll('Employee',[
            'filters'=>'[["user_id","=","22noorazilahawang93@gmail.com"]]'
    ]);

    // $res=$frappe->doctype()->getAll('User',[
    //     'filters'=>'[["user_type","=","System User"]]'
    // ],[
    //     [
    //         'doctype'=>'Employee',
    //         'key'=>'user_id',
    //         'mapped_key'=>['user.name'],
    //         'filters'=>'[["user_id","=","user.name"]]'
    //     ]
    // ]);
    dd($res);
    expect(count($res) > 0)->toBeTrue();
});


// it('can get doctype', function () {
//     $frappe = new Romb2on\Frappe\Frappe();
//     $res=$frappe->doctype()->getDoc('DocType','About Us Settings');

//     dd($res);
//     expect($res[0]->name == "User")->toBeTrue();
// });


it('can paginate doctype', function () {
    $frappe = new Romb2on\Frappe\Frappe();
    $res=$frappe->doctype()
        ->mount('DocType')
        ->orderBy("name, creation asc")
        ->fields('["name","creation"]')
        ->paginate(1,10)
        ->get();
    dd($res);
    expect(count($res->data) > 0)->toBeTrue();
});

it('can create data to frappe system', function () {
    $frappe = new Romb2on\Frappe\Frappe();
    $res=$frappe->doctype()->create('Customer',[
        'customer_name'=>'jurin'
    ]);
    dd($res);
    // expect($res->data->method == 'test jurin')->toBeTrue();
});