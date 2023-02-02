<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Attrproduct
 *
 * @property int $id
 * @property string $subject
 * @property string $value
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $Product
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereValue($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\AttrproductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Attrproduct onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attrproduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attrproduct withoutTrashed()
 */
	class Attrproduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BankAccount
 *
 * @property int $id
 * @property string $sheba
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereSheba($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUserId($value)
 * @mixin \Eloquent
 */
	class BankAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Basket
 *
 * @property int $id
 * @property int|null $save_step
 * @property string $status
 * @property bool|null $i_know_problem
 * @property int $serve_product_by_mechanic
 * @property string $mechanic_type
 * @property int|null $problem_id
 * @property int|null $carmodel_id
 * @property int|null $user_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Carmodel|null $Carmodel
 * @property-read Collection|\App\Models\Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read Collection|\App\Models\Rent[] $Prices
 * @property-read int|null $prices_count
 * @property-read \App\Models\Problem|null $Problem
 * @property-read Collection|\App\Models\Product[] $Products
 * @property-read int|null $products_count
 * @property-read \App\Models\Rent|null $Rent
 * @property-read Collection|\App\Models\Service[] $Services
 * @property-read int|null $services_count
 * @property-read \App\Models\User|null $User
 * @method static Builder|Basket newModelQuery()
 * @method static Builder|Basket newQuery()
 * @method static Builder|Basket query()
 * @method static Builder|Basket whereCarmodelId($value)
 * @method static Builder|Basket whereCreatedAt($value)
 * @method static Builder|Basket whereDeletedAt($value)
 * @method static Builder|Basket whereIKnowProblem($value)
 * @method static Builder|Basket whereId($value)
 * @method static Builder|Basket whereLatitude($value)
 * @method static Builder|Basket whereLongitude($value)
 * @method static Builder|Basket whereMechanicType($value)
 * @method static Builder|Basket whereProblemId($value)
 * @method static Builder|Basket whereSaveStep($value)
 * @method static Builder|Basket whereServeProductByMechanic($value)
 * @method static Builder|Basket whereStatus($value)
 * @method static Builder|Basket whereUpdatedAt($value)
 * @method static Builder|Basket whereUserId($value)
 * @mixin Eloquent
 * @property-read mixed $mechanic
 * @property-read mixed $last_basket
 * @property-read mixed $check_has_mechanic_basket
 * @method static Builder|Basket checkHasMechanicBasket()
 * @method static Builder|Basket activeStatus()
 * @method static Builder|Basket typeMobile()
 * @property string|null $delivery_step
 * @property-read Collection|\App\Models\Transaction[] $Transactions
 * @property-read int|null $transactions_count
 * @method static Builder|Basket whereDeliveryStep($value)
 */
	class Basket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Car
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $Orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $Services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car newQuery()
 * @method static \Illuminate\Database\Query\Builder|Car onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Car withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Car withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CarFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Carmodel[] $CarModel
 * @property-read int|null $car_model_count
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Servicecategory[] $Servicecategories
 * @property-read int|null $servicecategories_count
 */
	class Car extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Carmodel
 *
 * @property int $id
 * @property string $name
 * @property int $car_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Car $Car
 * @property-read Collection|Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @method static CarmodelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel newQuery()
 * @method static Builder|Carmodel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereUpdatedAt($value)
 * @method static Builder|Carmodel withTrashed()
 * @method static Builder|Carmodel withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @property-read Collection|Carmodel[] $Carmodels
 * @property-read int|null $carmodels_count
 */
	class Carmodel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Categoryproduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Categoryproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoryproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoryproduct query()
 * @mixin \Eloquent
 */
	class Categoryproduct extends \Eloquent {}
}

namespace App\Models{
/**
 * <<<<<<< HEAD
 * App\Models\City
 *
 * @property int $id
 * @property int $province_id
 * @property string|null $name
 * @property string|null $name_en
 * @property string|null $latitude
 * @property string|null $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereProvinceId($value)
 * @mixin \Eloquent
 * @method static create(string[] $array)
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @property string|null $slug
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSlug($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Color
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @method static \Database\Factories\ColorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $mechanic_id
 * @property int $accepted
 * @property string $context
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $parent_id
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dailywork
 *
 * @property int $id
 * @property string $day
 * @property string $from
 * @property string $to
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Dailywork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invite
 *
 * @property int $id
 * @property int $user_id
 * @property bool $accepted
 * @property int|null $invited_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $User
 * @method static Builder|Invite newModelQuery()
 * @method static Builder|Invite newQuery()
 * @method static Builder|Invite query()
 * @method static Builder|Invite whereAccepted($value)
 * @method static Builder|Invite whereCreatedAt($value)
 * @method static Builder|Invite whereId($value)
 * @method static Builder|Invite whereInvitedUserId($value)
 * @method static Builder|Invite whereUpdatedAt($value)
 * @method static Builder|Invite whereUserId($value)
 * @mixin Eloquent
 * @property string|null $invited_mobile_number
 * @property-read mixed $invite_user
 * @method static Builder|Invite whereInvitedMobileNumber($value)
 * @property string|null $invited_full_name
 * @method static Builder|Invite whereInvitedFullName($value)
 * @property float|null $price
 * @method static Builder|Invite wherePrice($value)
 */
	class Invite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $support_space
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereSupportSpace($value)
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Location onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereType($value)
 * @method static \Illuminate\Database\Query\Builder|Location withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Location withoutTrashed()
 * @method static \Database\Factories\LocationFactory factory(...$parameters)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mechanic
 *
 * @property int $id
 * @property string $type
 * @property string|null $full_name
 * @property int|null $parts_supplier
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $gender
 * @property int|null $supplier
 * @property string|null $license
 * @property string|null $identity_number
 * @property string|null $email
 * @property int $activated
 * @property string|null $type_vehicle
 * @property string|null $pelak
 * @property int|null $count_available
 * @property int $user_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read Collection|Location[] $Locations
 * @property-read int|null $locations_count
 * @property-read Mechanicaddress|null $MechanicAddress
 * @property-read Collection|Rate[] $Rates
 * @property-read int|null $rates_count
 * @property-read Collection|Service[] $ServiceOwn
 * @property-read int|null $service_own_count
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @property-read Car|null $carable
 * @property-read Collection|Dailywork[] $dailyworks
 * @property-read int|null $dailyworks_count
 * @property-read mixed $mobile_location
 * @property-read mixed $stable_location
 * @property-read Collection|Car[] $supportedBrands
 * @property-read int|null $supported_brands_count
 * @method static MechanicFactory factory(...$parameters)
 * @method static Builder|Mechanic newModelQuery()
 * @method static Builder|Mechanic newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mechanic onlyTrashed()
 * @method static Builder|Mechanic query()
 * @method static Builder|Mechanic whereActivated($value)
 * @method static Builder|Mechanic whereCountAvailable($value)
 * @method static Builder|Mechanic whereCreatedAt($value)
 * @method static Builder|Mechanic whereDeletedAt($value)
 * @method static Builder|Mechanic whereEmail($value)
 * @method static Builder|Mechanic whereFullName($value)
 * @method static Builder|Mechanic whereGender($value)
 * @method static Builder|Mechanic whereId($value)
 * @method static Builder|Mechanic whereIdentityNumber($value)
 * @method static Builder|Mechanic whereLicense($value)
 * @method static Builder|Mechanic whereName($value)
 * @method static Builder|Mechanic wherePartsSupplier($value)
 * @method static Builder|Mechanic wherePelak($value)
 * @method static Builder|Mechanic wherePhone($value)
 * @method static Builder|Mechanic whereSupplier($value)
 * @method static Builder|Mechanic whereType($value)
 * @method static Builder|Mechanic whereTypeVehicle($value)
 * @method static Builder|Mechanic whereUpdatedAt($value)
 * @method static Builder|Mechanic whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Mechanic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mechanic withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\User $User
 * @property-read Model|\Eloquent $Wallet
 */
	class Mechanic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mechanicaddress
 *
 * @property int $id
 * @property string|null $street
 * @property string|null $alley
 * @property string|null $flat
 * @property string|null $detail_address
 * @property int $province_id
 * @property int $city_id
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Database\Factories\MechanicaddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereAlley($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $support_space
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereSupportSpace($value)
 */
	class Mechanicaddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $status
 * @property float $amount
 * @property int $wallet_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Wallet $Wallet
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereStatus($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment whereWalletId($value)
 * @mixin Eloquent
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Permission withoutTrashed()
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Price
 *
 * @property int $id
 * @property float $amount
 * @property int $priceable_id
 * @property string $priceable_type
 * @property int $basket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Basket $Basket
 * @property-read Model|\Eloquent $priceable
 * @method static \Illuminate\Database\Eloquent\Builder|Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereBasketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price wherePriceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price wherePriceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Price extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @method static \Database\Factories\ProblemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Problem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $subject
 * @property float $price
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Attrproduct[] $Attrproducts
 * @property-read int|null $attrproducts_count
 * @property-read Collection|Order[] $Orders
 * @property-read int|null $orders_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSubject($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @method static ProductFactory factory(...$parameters)
 * @property int $carmodel_id
 * @property int $year_id
 * @method static Builder|Product whereCarmodelId($value)
 * @method static Builder|Product whereYearId($value)
 * @property-read Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * <<<<<<< HEAD
 * App\Models\Province
 *
 * @property int $id
 * @property int|null $country
 * @property string|null $name
 * @property string|null $name_en
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereNameEn($value)
 * @mixin \Eloquent
 * =======
 * @method static create(string[] $array)
 * @method static \Database\Factories\ProvinceFactory factory(...$parameters)
 * @property string|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereSlug($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rate
 *
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate query()
 * @mixin \Eloquent
 * @property-read \App\Models\User $User
 * @property int $id
 * @property int $rate
 * @property int $user_id
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Rate onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rate withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereDeletedAt($value)
 */
	class Rate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rent
 *
 * @property int $id
 * @property string $source
 * @property string $destination
 * @property int $basket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Basket $Basket
 * @property-read \App\Models\Price|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|Rent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereBasketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $distance_km
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereDistanceKm($value)
 */
	class Rent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property mixed $permissions
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $permissions_array
 * @property-read int|null $permissions_count
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $subject
 * @property string $description
 * @property float $price
 * @property int $car_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Car $Car
 * @property-read Collection|Mechanic[] $MechanicOwn
 * @property-read int|null $mechanic_own_count
 * @property-read Collection|Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read Collection|Order[] $Orders
 * @property-read int|null $orders_count
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static \Illuminate\Database\Query\Builder|Service onlyTrashed()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCarId($value)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDeletedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service wherePrice($value)
 * @method static Builder|Service whereSubject($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Service withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Service withoutTrashed()
 * @mixin Eloquent
 * @method static ServiceFactory factory(...$parameters)
 * @property-read Collection|Mechanicrequest[] $Mechanicrequests
 * @property-read int|null $mechanicrequests_count
 * @property-read Collection|Userrequest[] $Userrequests
 * @property-read int|null $userrequests_count
 * @property int $servicecategory_id
 * @property int $carmodel_id
 * @property-read Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read \App\Models\Carmodel $Carmodel
 * @property-read \App\Models\Servicecategory $Servicecategory
 * @method static Builder|Service whereCarmodelId($value)
 * @method static Builder|Service whereServicecategoryId($value)
 * @property-read mixed $where_in_service
 * @property-read string $name
 * @property-read int|null $price_count
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Servicecategory
 *
 * @property int $id
 * @property string $category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @method static ServicecategoryFactory factory(...$parameters)
 * @method static Builder|Servicecategory newModelQuery()
 * @method static Builder|Servicecategory newQuery()
 * @method static Builder|Servicecategory query()
 * @method static Builder|Servicecategory whereCategory($value)
 * @method static Builder|Servicecategory whereCreatedAt($value)
 * @method static Builder|Servicecategory whereId($value)
 * @method static Builder|Servicecategory whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|\App\Models\Car[] $Cars
 * @property-read int|null $cars_count
 * @property-read string $name
 */
	class Servicecategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $basket_id
 * @property float $amount
 * @property string $subject
 * @property string $AccessToken
 * @property string $invoiceID
 * @property string $status
 * @property string $CellNumber
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAccessToken($value)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereBasketId($value)
 * @method static Builder|Transaction whereCellNumber($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereInvoiceID($value)
 * @method static Builder|Transaction wherePayload($value)
 * @method static Builder|Transaction whereStatus($value)
 * @method static Builder|Transaction whereSubject($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $bank
 * @property string|null $trace_number
 * @property string|null $document_number
 * @property string|null $digital_receipt
 * @property string|null $is_suer_bank
 * @property string|null $card_number
 * @property string|null $access_token
 * @property-read \App\Models\Basket $Basket
 * @method static Builder|Transaction whereBank($value)
 * @method static Builder|Transaction whereCardNumber($value)
 * @method static Builder|Transaction whereDigitalReceipt($value)
 * @method static Builder|Transaction whereDocumentNumber($value)
 * @method static Builder|Transaction whereIsSuerBank($value)
 * @method static Builder|Transaction whereTraceNumber($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * <<<<<<< HEAD
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string $mobile
 * @property int $activated
 * @property string $national_identity
 * @property string $gender
 * @property string $password
 * @property int|null $addressbar_id
 * @property string|null $remember_token
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Useraddress|null $addressbar
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static MediableCollection|static[] all($columns = ['*'])
 * @method static UserFactory factory(...$parameters)
 * @method static MediableCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressbarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaMatchAll(bool $tags = [], bool $withVariants = false)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 * @method static create(array $input)
 * @method static paginate(int $int)
 * @method static first(): self
 * @method static latest()
 * @property-read Collection|Car[] $Cars
 * @property-read int|null $cars_count
 * @property-read Useraddress|null $Useraddress
 * @property-read BankAccount|null $bank_account
 * @property-read Mechanic|null $mechanic
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|VerificationCode[] $verificationCodes
 * @property-read int|null $verification_codes_count
 * @property-read Collection|Userrequest[] $Userrequests
 * @property-read int|null $userrequests_count
 * @property-read mixed $avatar
 * @property-read Collection|Comment[] $Comments
 * @property-read int|null $comments_count
 * @property-read Collection|Rate[] $Rates
 * @property-read int|null $rates_count
 * @property-read Userlocation $Userlocation
 * @property-read Collection|Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @property-read Collection|Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read Collection|Invite[] $Invites
 * @property-read int|null $invites_count
 * @property-read Model|Eloquent $Wallet
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Useraddress
 *
 * @property int $id
 * @property string|null $street
 * @property string|null $alley
 * @property string|null $flat
 * @property string|null $detail_address
 * @property string|null $lat
 * @property string|null $lon
 * @property int $province_id
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $Useraddress
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|Useraddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereAlley($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Useraddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Useraddress withoutTrashed()
 * @mixin \Eloquent
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $User
 * @method static \Database\Factories\UseraddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereUserId($value)
 */
	class Useraddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Userlocation
 *
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Userlocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Userlocation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userlocation withoutTrashed()
 * @method static \Database\Factories\UserlocationFactory factory(...$parameters)
 */
	class Userlocation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Userrequest
 *
 * @property int $id
 * @property int $status
 * @property int $user_id
 * @property int $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Service $Service
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereDeletedAt($value)
 */
	class Userrequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VerificationCode
 *
 * @property int $id
 * @property string $code
 * @property int $used
 * @property int|null $user_id
 * @property string $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\VerificationCodeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationCode whereUserId($value)
 * @mixin \Eloquent
 */
	class VerificationCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property float $amount
 * @property int $has_credit
 * @property int $walletable_id
 * @property string $walletable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet query()
 * @method static Builder|Wallet whereAmount($value)
 * @method static Builder|Wallet whereCreatedAt($value)
 * @method static Builder|Wallet whereHasCredit($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet whereUpdatedAt($value)
 * @method static Builder|Wallet whereWalletableId($value)
 * @method static Builder|Wallet whereWalletableType($value)
 * @mixin Eloquent
 * @property-read Model|Eloquent $Walletable
 * @property float $bonus
 * @method static Builder|Wallet whereBonus($value)
 * @property int $user_id
 * @property-read User $User
 * @method static Builder|Wallet whereUserId($value)
 * @property-read Collection|Payment[] $Payments
 * @property-read int|null $payments_count
 */
	class Wallet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Year
 *
 * @property int $id
 * @property string $name
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @method static \Database\Factories\YearFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year query()
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Year extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Yourcar
 *
 * @property int $id
 * @property string|null $pelak
 * @property int $year_id
 * @property int $color_id
 * @property int $carmodel_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Carmodel $Carmodel
 * @property-read \App\Models\Color $Color
 * @property-read \App\Models\User $User
 * @property-read \App\Models\Year $Year
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereCarmodelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar wherePelak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereYearId($value)
 * @mixin \Eloquent
 * @property string|null $shasi
 * @method static \Database\Factories\YourcarFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereShasi($value)
 */
	class Yourcar extends \Eloquent {}
}

