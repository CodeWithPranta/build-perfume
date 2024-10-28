<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Question; // Import Question model
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\FileUpload::make('photos')
                    ->multiple()
                    ->required()
                    ->panelLayout('grid')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('question_answers')
                    ->schema(function () {
                        $questions = Question::all(); // Fetch all questions
                        $selectFields = [];

                        // Check if questions are retrieved
                        if ($questions->isEmpty()) {
                            return []; // Return empty if no questions found
                        }

                        foreach ($questions as $question) {
                            // Assuming options is already an array
                            $options = $question->options;

                            // Debug: Check the structure of options
                            if (!is_array($options)) {
                                dd("Options are not an array for question ID {$question->id}: ", $options);
                            }

                            // Ensure options are properly formatted
                            $validOptions = collect($options)
                                ->filter(function ($option) {
                                    // Check that the 'name' exists and is not null
                                    return isset($option['name']) && $option['name'] !== null;
                                })
                                ->map(function ($option) {
                                    // Use the 'name' as the label and provide a unique value
                                    return [
                                        'value' => $option['name'], // Assign a unique value
                                        'label' => $option['name'], // Use name for label
                                    ];
                                })
                                ->pluck('label', 'value') // Extract label and value
                                ->toArray();

                            // Debug: Check the valid options
                            if (empty($validOptions)) {
                                dd("No valid options found for question ID {$question->id}: ", $options);
                            }

                            // Create the select field only if there are valid options
                            $selectFields[] = Forms\Components\Select::make('question_' . $question->id)
                                ->label($question->title) // Display the question title as the label
                                ->options($validOptions) // Set validated options
                                ->required();
                        }

                        return $selectFields; // Return all the dynamically generated select fields
                    })
                    ->required()
                    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
