<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Item\Contracts\ItemInterface;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests\CreateItemRequest;
use App\Item;
use App\ItemSize;
use App\OptionSize;
use App\ItemImage;
use Assets;
use Illuminate\Support\Facades\Auth;
use URL;
use Illuminate\Support\Facades\DB;
use JavaScript as Js;

class ItemController extends BaseController
{

    protected $item;
    protected $itemSize;
    protected $optionSize;
    private $userId;
    private $userStoreId;
    /**
     * @var User
     */
    private $user;
    /**
     * @var ItemInterface
     */
    private $itemInterface;

    /**
     * @param Item $item
     * @param User $user
     * @param ItemInterface $itemInterface
     * @internal param $ItemInterface $
     */
    public function __construct(Item $item, User $user, ItemInterface $itemInterface, ItemImage $itemImage, ItemSize $itemSize, OptionSize $optionSize)
    {
        $this->executeMiddlewares();
        $this->item = $item;
        $this->itemSize = $itemSize;

        if (Auth::user()->check()) {
            $this->userId = Auth::user()->get()->id;
            $u = $user->find($this->userId);
            $this->userStoreId = $u->store_id;
        }
        $this->user = $user;
        $this->itemInterface = $itemInterface;
        $this->itemImage = $itemImage;
    }

    public function executeMiddlewares()
    {
        $this->middleware('verifyIfOwnedItem');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->item->with('itemSize.optionSize')->whereStoreId($this->userStoreId)->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));

        if (!$this->userStoreId) {
            $data = $this->item->with('itemSize.optionSize')->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
        }

        $itemImage = $this->itemImage->get(['item_id']);

        Assets::add([
            URL::asset('js/search/SearchCtrl.js'),
            URL::asset('js/search/SearchSrvc.js'),
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        $item = '';
        $store = '';
        $hasImage = '';
        $status = '';

        return view('admin.items.list', compact('data', 'item', 'store', 'hasImage', 'status'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        Assets::add([
            URL::asset('js/item/AddItemCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
            URL::asset('js/store/StoreSrvc.js'),
            URL::asset('js/tags/TagSrvc.js'),
            URL::asset('js/event/EventSrvc.js'),
        ]);

        $ctrl = 'AddItemCtrl';
        $title = 'Add';

        $userStoreId = $this->userStoreId;

        return view('admin.items.form', compact('ctrl', 'title', 'userStoreId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateItemRequest $request
     * @return Response
     */
    public function store(CreateItemRequest $request)
    {
        $data = $request->all();

        if (isset($data['store'])) {
            $data['store_id'] = $data['store']['id'];
            unset($data['store']);
        }

        if (isset($data['discounted_price_start_date'])) {

            $c = new Carbon($data['discounted_price_start_date']);
            $data['discounted_price_start_date'] = $c->setTimezone('Asia/Manila')->setTime(0, 0)->toDateTimeString();
        }

        if (isset($data['discounted_price_end_date'])) {

            $c = new Carbon($data['discounted_price_end_date']);
            $data['discounted_price_end_date'] = $c->setTimezone('Asia/Manila')->setTime(0, 0)->toDateTimeString();
        }

        if ($this->userStoreId) {
            $data['store_id'] = $this->userStoreId;
        }

        $model = 'App\Item';
        $data['slug'] = $this->makeSlug($data['name'], $model);

        $data['related_item_code'] = $this->itemInterface->createItemVariation($data['store_id'], $data['sku']);

        $r = $this->item->create($data);

        return ['id' => $r->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->item->with('optionStatus')->find($id);

        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Assets::add([
            URL::asset('js/item/EditItemCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
            URL::asset('js/store/StoreSrvc.js'),
            URL::asset('js/tags/TagSrvc.js'),
            URL::asset('js/event/EventSrvc.js'),
        ]);

        Js::put(['id' => $id]);

        $ctrl = 'EditItemCtrl';
        $title = 'Edit';

        $userStoreId = $this->userStoreId;

        return view('admin.items.form', compact('ctrl', 'title', 'userStoreId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateItemRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(CreateItemRequest $request, $id)
    {

        $data = $request->all();

        $item = $this->item->find($id);

        unset($data['slug']);
        unset($data['item_category']);
        unset($data['item_size']);
        unset($data['item_tag']);
        unset($data['item_event']);

        if (isset($data['store'])) {
            $data['store_id'] = $data['store']['id'];
            unset($data['store']);
        }

        if (isset($data['discounted_price_start_date'])) {

            $c = new Carbon($data['discounted_price_start_date']);
            $data['discounted_price_start_date'] = $c->setTimezone('Asia/Manila')->setTime(0, 0)->toDateTimeString();
        }

        if (isset($data['discounted_price_end_date'])) {

            $c = new Carbon($data['discounted_price_end_date']);
            $data['discounted_price_end_date'] = $c->setTimezone('Asia/Manila')->setTime(0, 0)->toDateTimeString();
        }

        if ($this->userStoreId) {
            $data['store_id'] = $this->userStoreId;
        }

        $data['related_item_code'] = $this->itemInterface->createItemVariation($data['store_id'], $data['sku']);

        $item->fill($data)
            ->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->item->destroy($id);
    }

    /**
     * Retrieve single record
     * @param  int $id
     * @return object
     */
    public function getRecord($id)
    {
        return $this->item->with('itemCategory', 'itemImage', 'itemSize', 'itemTag', 'itemEvent.event')->find($id);
    }


    /**
     * Count total records
     * @return int
     */
    public function countRecords()
    {
        return $this->item->count();
    }

    public function search(Request $request)
    {

        Assets::add([
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        $req = $request->all();

        $item = (isset($req['item'])) ? $req['item'] : '';
        $store = (isset($req['store'])) ? $req['store'] : '';
        $hasImage = (isset($req['hasImage'])) ? $req['hasImage'] : '';
        $status = (isset($req['status'])) ? $req['status'] : '';

        //Item ids with item image
        $itemIds = $this->itemImage->lists('item_id');

        $data = $this->item->searchItemName($item)
            ->searchStore($store)
            ->searchHasImage($itemIds, $hasImage)
            ->searchStatus($status)
            ->orderBy('id', 'desc')
            ->paginate(\Config::get('constants.paginationLimit'));

        return view('admin.items.list', compact('data', 'item', 'store', 'hasImage', 'status'));

    }

    public function stockManagement()
    {
//		$data = $this->item->whereHas('itemSize', function ($q) use ($qty) {
//			$q->where('stock', '<=', $qty);
//		})->whereStoreId($this->userStoreId)->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
        //print_r($data);
        /*$data = $this->itemSize->whereStoreId($this->usersStoreId)
            ->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
        */

        if (!$this->userStoreId) {
            //$data = $this->item->orderBy('id', 'desc')->paginate(\Config::get('constants.paginationLimit'));
//			$data = $this->item->whereHas('itemSize', function ($q) use ($qty) {
//				$q->where('stock', '<=', $qty);
//			})->orderBy('id', 'desc')->get()->toArray();

            $data = $this->itemSize->where('stock', '<=', 1)
                ->paginate(\Config::get('constants.paginationLimit'));
            /*$data = $this->item->whereHas('itemSize', function ($q) use ($qty) {
            $q->where('stock', '<=', $qty);
            })->orderBy('id', 'desc')->get()->toArray();
            return "<pre>".dd($data)."</pre>"; */

        }

        $itemImage = $this->itemImage->get(['item_id']);

        Assets::add([
            URL::asset('js/search/SearchCtrl.js'),
            URL::asset('js/search/SearchSrvc.js'),
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        $item = '';
        $store = '';
        $hasImage = '';
        $status = '';
        $stock = '';

        return view('admin.items.stockManagement', compact('data', 'item', 'store', 'stock'));
    }

    public function noSize()
    {
//
        if (!$this->userStoreId) {


            $data = $this->item->whereDoesntHave('ItemSize')
                ->paginate(\Config::get('constants.paginationLimit'));
            //dd($this->item->itemSize->get()->toArray());
        }

        $itemImage = $this->itemImage->get(['item_id']);

        Assets::add([
            URL::asset('js/search/SearchCtrl.js'),
            URL::asset('js/search/SearchSrvc.js'),
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        $item = '';
        $store = '';
        $hasImage = '';
        $status = '';

        return view('admin.items.noSize', compact('data', 'item', 'store', 'hasImage', 'status'));
    }

    public function searchNoSize()
    {
        $store = (isset($_GET['store'])) ? $_GET['store'] : '';
        $data = $this->item->whereDoesntHave('ItemSize')
            ->searchStore($store)
            ->paginate(\Config::get('constants.paginationLimit'));
        Assets::add([
            URL::asset('js/search/SearchCtrl.js'),
            URL::asset('js/search/SearchSrvc.js'),
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        $item = '';
        //$store = '';
        $hasImage = '';
        $status = '';

        return view('admin.items.noSize', compact('data', 'item', 'store', 'hasImage', 'status'));
    }

    public function searchStockManagement()
    {
        $operator = "<=";
        $store = (isset($_GET['store'])) ? $_GET['store'] : '';
        $stock = (isset($_GET['stock'])) ? $_GET['stock'] : '';
        $stock == "" ? $stock = 1 : $operator = "=";
        $item = (isset($_GET['item'])) ? $_GET['item'] : '';
        $data = $this->itemSize->where('stock', $operator, $stock)
            ->WhereHas('item', function ($query) use ($store) {
                $query->WhereHas('store', function ($query) use ($store) {
                    $query->where('name', 'LIKE', "%$store%");
                });
            })
            ->WhereHas('item', function ($query) use ($item) {
                $query->where('name', 'LIKE', "%$item%");
            })
            ->paginate(\Config::get('constants.paginationLimit'));
        Assets::add([
            URL::asset('js/search/SearchCtrl.js'),
            URL::asset('js/search/SearchSrvc.js'),
            URL::asset('js/item/ItemListCtrl.js'),
            URL::asset('js/item/ItemSrvc.js'),
        ]);

        if (isset($_GET['stock'])) {
                if($_GET['stock']===0)
                    $stock = 0;
                else if($_GET['stock']==null)
                    $stock = '';
        }
        return view('admin.items.stockManagement', compact('data', 'item', 'store', 'stock'));
    }


}
