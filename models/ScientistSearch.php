<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Scientist;

/**
 * ScientistSearch represents the model behind the search form about `frontend\models\Scientist`.
 */
class ScientistSearch extends Scientist
{
    private $_where;
    public function __construct($where = ['status'=>Scientist::STATUS_ACTIVE], $config = [])
    {
        $this->_where = $where;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['name', 'city', 'biography', 'achievements', 'image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Scientist::find()->where($this->_where);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 12],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'biography', $this->biography])
            ->andFilterWhere(['like', 'achievements', $this->achievements])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
