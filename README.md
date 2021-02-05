

## About Laravel-8x-API
This API is created using Laravel 8x API Resource. Has email or phone Registration . registration of saccos,, Protected routes are also added. Protected routes are accessed via Passport access token.


## end points 


authentication EndPoints

- POST http://127.0.0.1:8000/api/auth/login
- POST http://127.0.0.1:8000/api/auth/register
- PUT  http://127.0.0.1:8000/api/auth/updateprofile/{id}
- GET  http://127.0.0.1:8000/api/auth/allusers
- DELETE http://127.0.0.1:8000/api/auth/deleteuser/{id}
- POST http://127.0.0.1:8000/api/auth/restoreuser/{id} 

Saccos EndPoints 

- GET  http://127.0.0.1:8000/api/allsaccos     
- GET  http://127.0.0.1:8000/api/allsaccos/{id}  
- POST http://127.0.0.1:8000/api/createsacco     
- PUT    http://127.0.0.1:8000/api/allsaccos/{id}     
- DELETE http://127.0.0.1:8000/api/deletesacco/{id}  
- POST http://127.0.0.1:8000/api/restoresacco/{id}  



## register
```php
public function register(Request $request ,User $user){
   $validator = Validator::make($request->all(),[
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
           // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'phone' => ['required', 'max:10', 'unique:users'],
           'password' => ['required', 'string', 'min:8'],
        //  'c_password' =>'required|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' =>$validator->errors()], 401);
        
        
    }
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    $success['token'] = $user->createToken('my accessToken')->accessToken;
    $success['name'] = $user->name;

    return response()->json(['message' => "register success",'success'=>$success], $this->successStatus);

      
}
```
- POST http://127.0.0.1:8000/api/auth/register
```json
 {
   "message": "register success",
   "success": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTVkNDM0NGNmYWJjYzY5MTIzMDIwZmY0OTZmMDY5NGFhOTc0NmRhM2QzNzZmY2IwNThkNTI3OTU4NTBjMjFmY2Q3MjY1ZWJhZTIxZWZiMjciLCJpYXQiOjE2MDA0MzIzMzAsIm5iZiI6MTYwMDQzMjMzMCwiZXhwIjoxNjMxOTY4MzMwLCJzdWIiOiIxMSIsInNjb3BlcyI6W119.Zmbdjc5rWgyArpPncD-m_qjHvVJAJpoxT4IKCoDajAql-uFfWc4t51ifHjT2-3XhvMccsLNY_s_n3GbRmMDZlLvkIhp0l0De7mUli2gy1BjBJQp6u1G_OMibDfhoTDh4ayL6nfQC5bISSXLaIMRdca6b9KdfqfbZRPa1KHAxQ6tkkTJWKqewKYPitXRlCE0OH1tFPIm3hKj8sT8mgOBlcFzqrvxr-it2ApFKiinaEMFJidyvNHFfljD9bKgavgv1_vYbvhdAla3t_hNlNuNL7-OgxZcGCVt8f1D3NBFVAPxX2i3-q9udUpMlOKVU1fg5ANpHYF3uDXD1ofxWRyTLcH-Sr6HWpBlGW6W796TlXFXO9ILuW9-q4Uu8WxO2CFwaiUFF2bQ-FxwufPG9SedqcmP_mMDwO6SUpOaKmrrI36_GuMA4ZwZ4WoTerVnHDsheTlwaMFQgFjVXjQPAV5FMPlXqWWR77xlIRNkKTzy-wzW9Qo7x3hL4R-Be-Q10jobUNgs5qsmezFbmP_zQtrQx-JBBfVCMI9VFqeSDV3Is3w9vQVIVu-rxUmy_rauR9oNDRie1naTafs6IhW49Bq1itVOf3jgdxqs_HliBczOisCCYMHPDYiRnngT3ff_3r3DkQ2Fvy2W2HP5hUB7hHEb67ZO5ttIVRzjUSDoIcoHSQkA",
       "name": "dennis"
   }
 }
```

## login
```php
public function login(Request $request ,User $user){

        $request->validate([
        //'email' => 'required',
        'phone' => 'required',
        'password' => 'required'
    ]);
        

       // if (Auth::attempt(['email' => request('email'), 
        if (Auth::attempt(['phone' => request('phone'), 
            'password'=> request('password')])) {
            $user = Auth::user();
           $success['token'] = $user->createToken('my accessToken')->accessToken;

        return response()->json(['user data' =>[
                 'message' => "successfully login",
                'user' => Auth::user(),
                'access_token' => $success,
                'token_type' => 'Bearer',
                //'expires_at' =>Carbon::parse($success->expires_at)->toDateTimeString()
            ]]);

           
        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

```

POST = http://127.0.0.1:8000/api/auth/login

```json
{
    "user data": {
        "message": "successfully login",
        "user": {
            "id": 10,
            "name": "dennis",
            "email": "dennis190@gmail.com",
            "email_verified_at": null,
            "created_at": "2020-09-18T12:26:46.000000Z",
            "updated_at": "2020-09-18T12:26:46.000000Z",
            "deleted_at": null
        },
        "access_token": {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjk3ZjllMTA5YzBiZDFmMmI2OTA2MDVlOGFiZDRjMDU4MzIxYzQyMTJiODZkYTI3Mjc1ZDI2MTA3ZGU4ODExYjYxZmQyYmYyYjE2ZGM5NDUiLCJpYXQiOjE2MDA0MzIxMzgsIm5iZiI6MTYwMDQzMjEzOCwiZXhwIjoxNjMxOTY4MTM4LCJzdWIiOiIxMCIsInNjb3BlcyI6W119.TYdIANO2Mz9XzRSUKOUN1B9l1TbqbajycvOJKeief8RCv3ppQNAExZLJ2kOMzpUO_G3bfT_NO8Z8hewxWCl7G2CAx7R5y24baPAl53TbRQ9MtXfTy1i62iCl9Jl6gosP0DzK7dFy1fsDxk3-zgbDeylnWLwpiudDF-57g8lZjPyJHtzFUauf6qgbYW01MhW-TbMF9Qr5JbG0M3C6NHQ1FmS0KAgK64GnbxdXg_NiRPf-UYpXcGckTe_5dRKX-Oy8x5S6G3SID7ddYo6GluGDXzNppxNHyYfYcg9qVwyAT-KxjW668rzHvIer65kqVRzjHLMWpGgGSrG91J-vOB_RrRNwaTAsr6jYqBcl_Whe41mVjhNhjzOqCy-CRvKx5iJk7aQ-bxUavBA5QHkhNcKPg9BxKHlh_I61-vDf1GQnspo2MWeSiG1S27dJvNg5n5jVG7H_79BKXSZOhlTlOxAThxgcrjIaJQpUfn4rNa8-IvDCAY1dYJAyu9osJkPKGOo50h1xdAepdq8-Akv3PR8OE5E1UoIsuYxsu9DFWRszoLRApbSfL_5Ovu0kS6czNOGHG2CH6SspWmsz9NWL0TP8NkyfYqrDu_TdP00sC_9CGyf2iQgUr2SCQ6Bl8bpxk5yiOkcX5L_9yNBkWdny5ycCdW7jr7WRfq-VMGBSmtge8FI"
        },
        "token_type": "Bearer"
    }
}
```
## updating User profile

PUT  http://127.0.0.1:8000/api/auth/updateprofile/{id}
```php
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

         $updatedData = $user->update($request->all());

      return response()->json(["message" => "updated successfully!!"], 200);
    }

```

## Deleting User
DELETE http://127.0.0.1:8000/api/auth/deleteuser/{id}

```php
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, User $user)
    {
         $user->delete();
        return response()->json(["message" => "deleted successfully!!"], 200);
    }
```
## Restore Deleted User
POST http://127.0.0.1:8000/api/auth/restoreuser/{id} 
   
   ```php
    public function restore($id, User $user){

       $data = User::withTrashed()->find($id);
       $data->restore();

        return response()->json(["message" => "user restored successfully!!"], 200);

    }

```

## all users
```php
/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = User::paginate(2);
        return response()->json(["users" =>$user]);

    }
```
GET  http://127.0.0.1:8000/api/auth/allusers
```json
{"users":{"current_page":1,"data":[{"id":1,"firstname":"dennis","lastname":"mwangi","phone":721941386,"created_at":"2021-02-05T13:18:21.000000Z","updated_at":"2021-02-05T13:18:21.000000Z","deleted_at":null},{"id":2,"firstname":"dennis","lastname":"mwangi","phone":721941386,"created_at":"2021-02-05T13:19:34.000000Z","updated_at":"2021-02-05T13:19:34.000000Z","deleted_at":null}],"first_page_url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=1","from":1,"last_page":2,"last_page_url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=2","links":[{"url":null,"label":"Previous","active":false},{"url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=1","label":1,"active":true},{"url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=2","label":2,"active":false},{"url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=2","label":"Next","active":false}],"next_page_url":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers?page=2","path":"http:\/\/127.0.0.1:8000\/api\/auth\/allusers","per_page":2,"prev_page_url":null,"to":2,"total":3}}




{
    "users": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "api test9",
                "email": "testinguipi@gmail.com",
                "email_verified_at": null,
                "created_at": "2020-09-18T09:21:15.000000Z",
                "updated_at": "2020-09-18T09:21:15.000000Z",
                "deleted_at": null
            },
            {
                "id": 2,
                "name": "dennis",
                "email": "dennis@gmail.com",
                "email_verified_at": null,
                "created_at": "2020-09-18T09:28:49.000000Z",
                "updated_at": "2020-09-18T09:28:49.000000Z",
                "deleted_at": null
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/auth/allusers?page=1",
        "from": 1,
        "last_page": 4,
        "last_page_url": "http://127.0.0.1:8000/api/auth/allusers?page=4",
        "links": [
            {
                "url": null,
                "label": "Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/auth/allusers?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": "http://127.0.0.1:8000/api/auth/allusers?page=2",
                "label": 2,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/auth/allusers?page=3",
                "label": 3,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/auth/allusers?page=4",
                "label": 4,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/auth/allusers?page=2",
                "label": "Next",
                "active": false
            }
        ],
        "next_page_url": "http://127.0.0.1:8000/api/auth/allusers?page=2",
        "path": "http://127.0.0.1:8000/api/auth/allusers",
        "per_page": 2,
        "prev_page_url": null,
        "to": 2,
        "total": 8
    }
}
```
## saccos --------------------------------------
```php
public function store(Request $request)
    {
        
       $validator = Validator::make($request->all(),[
        'name' => ['required', 'string', 'max:255','unique:saccos'],
            'description' => ['required', 'string',],
           'time_of_contribution' => 'required',
          'min_to_contribute' =>'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' =>$validator->errors()], 401);
        # code...
        
    }

    $input = $request->all();
    $sacco = Saccos::create($input);

    return response()->json(['success'=>" sacco created successfully"], 200);
        
    }
```
POST http://127.0.0.1:8000/api/createsacco 
```json
{
    "success": " sacco created successfully"
}
```
## All saccos

```php
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sacco = Saccos::paginate(2);
        return response()->json(["saccos"=>$sacco]);


    }

```
GET  http://127.0.0.1:8000/api/allsaccos 
```php
{
    "saccos": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "chama test",
                "description": "chama to contribute",
                "time_of_contribution": "12:00",
                "min_to_contribute": "100",
                "created_at": "2020-09-18T10:13:06.000000Z",
                "updated_at": "2020-09-18T10:13:06.000000Z",
                "deleted_at": null
            },
            {
                "id": 2,
                "name": "demo",
                "description": "demo test",
                "time_of_contribution": "12:00",
                "min_to_contribute": "20",
                "created_at": "2020-09-18T10:27:28.000000Z",
                "updated_at": "2020-09-18T10:27:28.000000Z",
                "deleted_at": null
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/allsaccos?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://127.0.0.1:8000/api/allsaccos?page=2",
        "links": [
            {
                "url": null,
                "label": "Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/allsaccos?page=1",
                "label": 1,
                "active": true
            },
            {
                "url": "http://127.0.0.1:8000/api/allsaccos?page=2",
                "label": 2,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/allsaccos?page=2",
                "label": "Next",
                "active": false
            }
        ],
        "next_page_url": "http://127.0.0.1:8000/api/allsaccos?page=2",
        "path": "http://127.0.0.1:8000/api/allsaccos",
        "per_page": 2,
        "prev_page_url": null,
        "to": 2,
        "total": 3
    }
}
```
=======

#### Usage
Clone the project via git clone or download the zip file.

##### .env
Copy contents of .env.example file to .env file. Create a database and connect your database in .env file.
##### Composer Install
cd into the project directory via terminal and run the following  command to install composer packages.
###### `composer install`
##### Generate Key
then run the following command to generate fresh key.
###### `php artisan key:generate`
##### Run Migration
then run the following command to create migrations in the databbase.
###### `php artisan migrate`
##### Passport Install
run the following command to install passport
###### `php artisan passport:install`
then run the following command to create migrations in the databbase.
###### `php artisan migrate`
## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
## Code of Conduct

Please make sure to update tests as appropriate.



## Security Vulnerabilities

Please inform me if you find any security vulnerabilities

## License

[MIT](https://choosealicense.com/licenses/mit/)
