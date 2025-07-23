<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter; // For status filter
use Filament\Forms\Components\Select; // For status dropdown
use Filament\Forms\Components\DatePicker; // For delivery_at date picker
use Filament\Forms\Components\TextInput; // For total amount display
use Filament\Forms\Components\Grid; // For layout
use Filament\Forms\Components\Section; // For grouping fields
use Filament\Forms\Components\Repeater; // To display order items
use Filament\Forms\Components\Placeholder; // For static text/values
use Filament\Tables\Columns\BadgeColumn; // For status badge
use Filament\Tables\Columns\TextColumn; // For general text columns
use Filament\Forms\Components\Hidden; // If you need to store hidden values

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Shop Management'; // Optional: Group your shop resources

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3) // Divide the form into 3 columns
                    ->schema([
                        Section::make('Order Details')
                            ->columnSpan(2) // This section takes 2 out of 3 columns
                            ->schema([
                                Placeholder::make('Order ID')
                                    ->content(fn (?Order $record): string => $record ? $record->id : 'N/A'),

                                Placeholder::make('Customer')
                                    ->content(fn (?Order $record): string => $record ? ($record->user ? $record->user->name . ' (' . $record->user->email . ')' : 'Guest') : 'N/A'),

                                Placeholder::make('Total Amount')
                                    ->content(fn (?Order $record): string => $record ? '$' . number_format($record->total_amount, 2) : 'N/A'),

                                Placeholder::make('Ordered At')
                                    ->content(fn (?Order $record): string => $record ? $record->created_at->format('M d, Y H:i A') : 'N/A'),
                            ]),

                        Section::make('Delivery Information')
                            ->columnSpan(1) // This section takes 1 out of 3 columns
                            ->schema([
                                Select::make('delivery_status')
                                    ->label('Delivery Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->native(false) // For better styling
                                    ->columnSpanFull(),

                                DatePicker::make('delivery_at')
                                    ->label('Delivery Date')
                                    ->nullable()
                                    ->placeholder('Select delivery date')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name') // Assuming Order belongs to User
                    ->label('Customer Name')
                    ->default('Guest') // If order can be guest
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('usd') // Format as currency
                    ->sortable()
                    ->summarize([ // Optional: show sum at bottom
                        Tables\Columns\Summarizers\Sum::make()->money('usd'),
                    ]),

                BadgeColumn::make('delivery_status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'pending',
                        'info' => 'processing',
                        'warning' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('delivery_at')
                    ->label('Delivered On')
                    ->date('M d, Y') // Format the date
                    ->placeholder('Not delivered yet')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ordered At')
                    ->dateTime('M d, Y H:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->placeholder('All Statuses')
                    ->label('Filter by Status'),

                // Optional: Filter by date range for created_at
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // If you want a separate tab for order items, you could add:
            // RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'), // Orders are usually created by users, not admin
            // 'view' => Pages\ViewOrder::route('/{record}'), // Added a dedicated view page
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
